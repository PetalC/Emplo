<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\GoogleMaps;
use App\Services\ZohoRecruit;
use App\Services\ZohoCrm;
use App\Models\ZohoAccess;
use App\Models\School;
use App\Models\Campus;
use App\Models\CampusProfile;
use App\Models\Religion;
use App\Models\Sector;
use App\Models\LocationType;
use App\Models\SchoolType;
use App\Models\SchoolGender;
use App\Models\Curriculum;

use Carbon\Carbon;
use Validator;

/**
 * Creates a Job
 */
class ImportZohoCrmSchools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:import-crm-schools {--M|modified-only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports Zoho Recruit Schools';

    /** @var array */
    protected $messages;

    /**
     * Creates a new Command instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->messages = [];
    }

    /**
     * Main Processing to handle the Command
     *
     * @return Response
     */
    public function handle()
    {
        $isModifiedOnly = $this->option('modified-only');

        $this->info('================= Initiate Import Process ==================', "\n");

        if (!$this->_validate()) {
            return Command::FAILURE;
        }

        try {
            $initialImport = \DB::table('zoho_import_process')
                ->where('status', 'Completed')
                ->where('category', 'Initial')
                ->first();

            /* Check if Sync is completed on current day */
            $completed = \DB::table('zoho_import_process')
                ->where('status', 'Completed')
                ->where('created_at', '>=', date('Y-m-d 00:00:00'))
                ->where('created_at', '<=', date('Y-m-d 23:59:59'))
                ->first();

            if ($completed) {
                $this->info('================= All Schools has been imported ==================', "\n");
                return Command::SUCCESS;
            }

            $importProcess = \DB::table('zoho_import_process')->where('status', 'Ongoing')->first();

            if (!$importProcess) {
                $page = 1;
            } else {
                $page = $importProcess->page;
            }

            $page = (int)$page;

            $crmAPI = new ZohoCrm();

            $modifiedAt = '';
            $category = 'Full';
            if ($isModifiedOnly) {
                $modifiedAt = new Carbon();
                $modifiedAt->subDays(1);
                $modifiedAt = $modifiedAt->format('Y-m-d').'T00:00:00+10:00';
                $category = 'Modified';
            }

            if (!$initialImport) {
                $modifiedAt = '';
                $category = 'Initial';
            }

            $clients = $crmAPI->getRecords("Accounts?page=$page", null, $modifiedAt);

            foreach ($clients->data as $client) {
                $this->info("$client->id $client->Account_Name");

                switch ($client->Shipping_State) {
                    case 'ACT':
                        $state = 'Australian Capital Territory';
                        break;

                    case 'NSW':
                        $state = 'New South Wales';
                        break;

                    case 'NT':
                        $state = 'Northern Territory';
                        break;

                    case 'QLD':
                        $state = 'Queensland';
                        break;

                    case 'SA':
                        $state = 'South Australia';
                        break;

                    case 'TAS':
                        $state = 'Tasmania';
                        break;

                    case 'VIC':
                        $state = 'Victoria';
                        break;

                    case 'WA':
                        $state = 'Western Australia';
                        break;

                    default:
                        $state = '';
                        break;
                }

                /* Check if School Exists otherwise create a new Entity */
                $existingSchool = School::where('zoho_crm_id', $client->id)->first();

                $school = new School();
                $school->zoho_crm_id = $client->id;

                $campus = new Campus();
                $campus->is_primary = 1;

                if ($existingSchool) {
                    $school = $existingSchool;

                    if ($school->primaryCampus) {
                        $campus = $school->primaryCampus;
                    }
                }

                /* Cleanse Imported School Name */
                $originalEncoding = 'UTF-8';
                $targetEncoding = 'UTF-8';

                $schoolName = mb_convert_encoding($client->Account_Name, $targetEncoding, $originalEncoding);
                $schoolName = preg_replace('/[^\x{0000}-\x{007F}]+/u', '', $schoolName);

                /**
                 * Create the School Entity
                 */
                $school->name = $schoolName;
                $school->save();

                /**
                 * Create the associated Campus
                 */
                $campus->school_id = $school->id;

                $slug = Str::slug($schoolName);

                $exists = Campus::where('url_slug', $slug)->exists();

                if( $exists ) {
                    $iteration = 1;
                    while( $exists ){
                        $slug = Str::slug($schoolName) . '-' . $iteration;
                        $exists = Campus::where('url_slug', $slug)->exists();
                        $iteration++;
                    }
                }

                $campus->url_slug = $slug;
                $campus->is_primary = 1;
                $campus->save();

                if (!$existingSchool) {
                    /**
                     * Create the Default Active Campus Profile
                     */
                    $profile = new CampusProfile();
                    $profile->campus_id = $campus->id;
                    $profile->name = $schoolName;
                    $profile->description = '';
                    $profile->proposition = '';
                    $profile->is_active = 1;

                    $profile->address = (!empty($client->Shipping_Street)) ? $client->Shipping_Street : '';
                    $profile->country = (!empty($client->Shipping_Country)) ? $client->Shipping_Country : 'Australia';
                    $profile->state = (!empty($state)) ? $state : '';
                    $profile->city = (!empty($client->Shipping_City)) ? $client->Shipping_City : '';
                    $profile->zipcode = (!empty($client->Shipping_Code)) ? $client->Shipping_Code : '';

                    $profile->student_enrollments = (!empty($client->Student_Enrolments)) ? $client->Student_Enrolments : 0;
                    $profile->staff_size = (!empty($client->Employees)) ? $client->Employees : 0;

                    /* Get the latitude and longtitude */
                    $googleMaps = new GoogleMaps();
                    $location = $googleMaps->getGeolocation($profile->country, $profile->state, $profile->city, $profile->address, $profile->zipcode);

                    if (isset($location->results[0]->geometry)) {
                        $profile->latitude = $location->results[0]->geometry->location->lat;
                        $profile->longitude = $location->results[0]->geometry->location->lng;
                    }

                    $profile->save();

                    $this->_createTaxonomies($profile, $client);
                }
            }

            if (!$importProcess) {
                \DB::table('zoho_import_process')->insert(
                    [
                        'status' => 'Ongoing',
                        'category' => $category,
                        'page' => 2,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
            } else {
                $status = 'Ongoing';
                $page = $page + 1;

                if ($clients->info->count < 200) {
                    $status = 'Completed';
                }

                \DB::table('zoho_import_process')
                    ->where('id', $importProcess->id)
                    ->update(
                    [
                        'status' => $status,
                        'page' => $page,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );
            }

            $this->info('================= Terminating Command ==================', "\n");
            return true;

        } catch (\Exception $error) {
            $this->info('================= Error! '.$error->getMessage().' ==================', "\n");
            $this->messages = [$error->getMessage()];
            return false;
        }
    }

    /**
     * Validates the input
     *
     * @return Response
     */
    private function _validate()
    {
        return true;
    }

    private function _createTaxonomies(CampusProfile $profile, $zohoSchool)
    {
        /* Religion */
        if ($zohoSchool->Religion) {
            $religion = Religion::firstOrCreate([
                'name' => $zohoSchool->Religion
            ]);

            \DB::table('profile_taxonomies')->insert(
                [
                    'campus_profile_id' => $profile->id,
                    'taxonomy_type' => 'App\Models\Religion',
                    'taxonomy_id' => $religion->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        /* Sector */
        if ($zohoSchool->Sector) {
            $sector = Sector::firstOrCreate([
                'name' => $zohoSchool->Sector
            ]);

            \DB::table('profile_taxonomies')->insert(
                [
                    'campus_profile_id' => $profile->id,
                    'taxonomy_type' => 'App\Models\Sector',
                    'taxonomy_id' => $sector->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        /* Location Types */
        foreach ($zohoSchool->Geographic_Region as $locationType) {
            $location = LocationType::firstOrCreate([
                'name' => $locationType
            ]);

            \DB::table('profile_taxonomies')->insert(
                [
                    'campus_profile_id' => $profile->id,
                    'taxonomy_type' => 'App\Models\LocationType',
                    'taxonomy_id' => $location->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        /* School Type */
        if ($zohoSchool->Type) {
            $type = SchoolType::firstOrCreate([
                'name' => $zohoSchool->Type
            ]);

            \DB::table('profile_taxonomies')->insert(
                [
                    'campus_profile_id' => $profile->id,
                    'taxonomy_type' => 'App\Models\SchoolType',
                    'taxonomy_id' => $type->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        /* Gender */
        if ($zohoSchool->Gender) {
            $gender = SchoolGender::firstOrCreate([
                'name' => $zohoSchool->Gender
            ]);

            \DB::table('profile_taxonomies')->insert(
                [
                    'campus_profile_id' => $profile->id,
                    'taxonomy_type' => 'App\Models\SchoolGender',
                    'taxonomy_id' => $gender->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        /* Curriculum */
        foreach ($zohoSchool->Curriculum as $schoolCurriculum) {
            $curriculum = Curriculum::firstOrCreate([
                'name' => $schoolCurriculum
            ]);

            \DB::table('profile_taxonomies')->insert(
                [
                    'campus_profile_id' => $profile->id,
                    'taxonomy_type' => 'App\Models\Curriculum',
                    'taxonomy_id' => $curriculum->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }
    }
}
