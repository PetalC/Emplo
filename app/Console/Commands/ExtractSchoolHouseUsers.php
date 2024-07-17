<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\School;
use App\Models\Campus;
use App\Models\CampusProfile;
use App\Models\User;
use App\Models\Profile;

use Carbon\Carbon;
use Validator;

/**
 * Creates a Job
 */
class ExtractSchoolHouseUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:extract-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract Existing Users from SchoolHouse';

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
        $this->info('================= Initiate Extraction Process ==================', "\n");

        if (!$this->_validate()) {
            return false;
        }

        try {
            $jsonData = $this->_getUsers();
            $ctr = 0;

            foreach ($jsonData->collection as $schUser) {

                if (!$schUser->deleted_at) {
                    $this->info('================= Processing '.$schUser->name.' ==================', "\n");

                    $user = User::where('email', $schUser->email)->first();

                    if (!$user) {
                        $user = new User();
                        $user->email = $schUser->email;
                    }

                    $user->first_name = $schUser->firstname;
                    $user->last_name = $schUser->lastname;
                    $user->password = $schUser->password;
                    $user->role = $schUser->role;
                    $user->school_role = $schUser->school_role;
                    $user->school = 0;

                    /* For School Type of Users */
                    if ($schUser->school) {
                        $schSchool = $schUser->school_profile;

                        $school = School::where('name', $schSchool->name)->first();

                        if (!$school) {
                            continue;
                        }

                        $campus = $school->primaryCampus;
                        $campusProfile = $campus->primary_profile;

                        $this->info('================= Updating '.$school->name.' ==================', "\n");
                        $user->school = $school->id;

                        $campusProfile->description = $schSchool->description;
                        $campusProfile->proposition = $schSchool->proposition;
                        $campusProfile->video_url = $schSchool->video_url;
                        $campusProfile->youtube_embed_url = $schSchool->youtube_embed_url;

                        $campusProfile->save();
                    }

                    $user->save();
                  
                    /* For Candidate Type of Users */
                    if (!$schUser->school) {
                        $schProfile = $schUser->profile;
                        $profile = new Profile();

                        $profile->user_id = $user->id;
                        
                        $profile->address = $schProfile->address;
                        $profile->city = $schProfile->city;
                        $profile->state = $schProfile->state;
                        $profile->zipcode = $schProfile->zipcode;
                        $profile->country = $schProfile->country;
                        $profile->latitude = $schProfile->latitude;
                        $profile->longitude = $schProfile->longtitude;

                        $profile->brief = $schProfile->brief;
                        $profile->basic_information = $schProfile->basic_information;
                        $profile->years_of_experience = $schProfile->years_of_experience;
                        $profile->has_accepted_sustainability = $schProfile->has_accepted_sustainability;
                        $profile->minimum_salary = $schProfile->minimum_salary;
                        $profile->maximum_salary = $schProfile->maximum_salary;

                        $profile->save();
                    }
                  
                    $ctr++;
                }
              
            }

            dd($ctr);

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

    private function _getUsers()
    {
        $url = 'https://the-schoolhouse.com.au/api/users';

        $headers = array(
            'Content-type: application/json',
        );

        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);

        $data = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $jsonData = json_decode($data);

        curl_close($handle);

        return $jsonData;
    }
}
