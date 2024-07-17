<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\ApplicationStatuses;
use App\Enums\EmploymentType;
use App\Enums\InterviewStatus;
use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\LicencingAuthorityTypes;
use App\Enums\SalaryTypes;
use App\Enums\VacancyReasons;
use App\Observers\JobObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\ZohoRecruit;
use App\Services\TeachersOnNetRest;
use App\Services\SeekGraph;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property Campus campus
 */
#[ObservedBy(JobObserver::class)]
class Job extends Model implements HasMedia {

    use HasFactory, Searchable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'campus_id',
        'title',
        'description',
        'selling_points',
        'responsibilities',
        'required_licences_certs',
        'salary_min',
        'salary_max',
        'salary_type',
        'job_length_id',
        'location_type_id',
        'position_type_id',
        'position_title_id',
        'offers_relocation',
        'offers_housing',
        'recommended',
        'employment_type',
        'vacancy_reason',
        'licencing_authority',
        'routing_preference',
        'external_application_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'employment_type' => JobType::class,
        'salary_type' => SalaryTypes::class,
        'vacancy_reason' => VacancyReasons::class,
        'licencing_authority' => LicencingAuthorityTypes::class,
        'status' => JobStatus::class,
        'salary_min' => 'integer',
        'salary_max' => 'integer',
        'created_at' => 'date',
        'offers_relocation' => 'boolean',
        'offers_housing' => 'boolean',
        'start_date' => 'date',
    ];

    /**
     * Get school instance
     */
    public function school(): BelongsTo {
        return $this->belongsTo(School::class);
    }

    /**
     * Get campus instance
     */
    public function campus(): BelongsTo {
        return $this->belongsTo(Campus::class);
    }

    public function reference_checks(): HasMany
    {
        return $this->hasMany(ReferenceCheck::class);
    }

    public function job_length(): BelongsTo {
        return $this->belongsTo(JobLength::class);
    }

    public function position_type(): BelongsTo {
        return $this->belongsTo(PositionType::class);
    }

    public function subjects(): MorphToMany {
        return $this->morphedByMany(
            Subject::class,
            'taxonomy',
            'job_taxonomies',
        );
    }

    public function position_title(){
        return $this->belongsTo(PositionTitle::class);
    }

    public function applications(): HasMany {
        return $this->hasMany(Application::class );
    }

    public function panel() {
        return $this->hasOne(JobPanel::class);
    }

    public function panel_members() {
        return $this->belongsToMany(User::class, JobPanel::class, 'job_id', 'user_id', null, 'id');
    }

    public function postings(): HasMany {
        return $this->hasMany(JobBoardPostings::class);
    }

    public function getCandidateStatisticsAttribute(){

        $stats = false;//Cache::get('candidate_statistics_'. $this->id );

        if( ! $stats ){

            $applications = $this->applications()->whereNotIn('status', [
                ApplicationStatuses::STATUS_DRAFT, // not yet submitted by applicant
                ApplicationStatuses::STATUS_WITHDRAWN // soft deleted by applicant
            ] );

            $total_count = $applications->count();
            $shortlisted = $applications->where('status', ApplicationStatuses::STATUS_SHORTLISTED )->count();
            $declined = $applications->where('status', ApplicationStatuses::STATUS_DECLINED )->count();
            $hired = $applications->where('status', ApplicationStatuses::STATUS_HIRED )->count();

            $scheduled_interviews = $this->applications()->whereHas( 'interview', function( Builder $query ){
                $query->where('status', InterviewStatus::SCHEDULED->value );
            } )->count();

            $stats = [
                'scheduled_interviews' => $scheduled_interviews,
                'total_applications' => $total_count,
                'shortlisted' => $shortlisted,
                'declined' => $declined,
                'hired' => $hired,
            ];

            Cache::put('candidate_statistics_'. $this->id, $stats, 60 * 60 * 24 );

        }

        return $stats;

    }

    public function isNearUser(): bool
    {

        if( ! Auth::check() ){
            return false;
        }

        if( ! Auth::user()->profile ){
            return false;
        }

        if( ! $this->campus->primary_profile ){
            return false;
        }

        return ( Auth::check() && Auth::user()->profile->city == $this->campus->primary_profile->city );
    }

    /**
     * Starting Soon and Recommended come from the Job Lengths
     *
     * @return bool
     */
    public function startingSoon(): bool {
        return $this->start_date <= now()->addDays(30);
    }

    public function jobLength(): bool {

        if( $this->job_length ){
            return $this->job_length->name;
        }

        return false;

    }

    public function isRecommended(): bool {
        return $this->recommended;
    }

    public function getRouteKeyName(): string {
        return 'uuid';
    }

    public function createZohoRecruitJob() {

        $zohoRecruitAPI = new ZohoRecruit();
        $fields = new \stdClass();

        $fields->data = [];
        $data = new \stdClass();
        $data->Job_Opening_Name = $this->title;
        $data->Job_Description = $this->description.$this->responsibilities.$this->required_licences_certs;
        $data->Client_Name = $this->school->name;
        $data->Job_Type = $this->employment_type;
        $data->Target_Date = date('Y-m-d', strtotime($this->start_date));
        $data->Alert_Date = date('Y-m-d');
        $data->Alert_Location = $this->campus->primary_profile->city;
        $data->Territory = (!empty($this->campus->primary_profile->city)) ? $job->campus->primary_profile->city : 'None';
        $data->General_Area_Eg_Secondary = [$this->position_type->name];
        $data->Job_Source = ["Employo website"];

        /* Subjects */
        $data->Subjects = [];
        foreach ($this->subjects as $subject) {
            $data->Subjects[] = $subject->name;
        }

        $fields->data[] = $data;
        $jsonData = $zohoRecruitAPI->insertRecord($fields, 'Job_Openings');

        /* Save Zoho ID */
        $this->zoho_id = $jsonData->data[0]->details->id;
        $this->save();

        return $this;
    }

    public function updateZohoRecruitJob()
    {
        $zohoRecruitAPI = new ZohoRecruit();
        $fields = new \stdClass();

        $fields->data = [];
        $data = new \stdClass();
        $data->id = $this->zoho_id;
        $data->Job_Opening_Name = $this->title;
        $data->Job_Description = $this->description.$this->responsibilities.$this->required_licences_certs;
        $data->Job_Type = $this->employment_type;
        $data->Target_Date = date('Y-m-d', strtotime($this->start_date));
        $data->Alert_Date = date('Y-m-d');
        $data->Alert_Location = $this->campus->primary_profile->city;
        $data->Territory = $this->campus->primary_profile->city;
        $data->Job_Opening_Status = "In-progress";
        $data->General_Area_Eg_Secondary = [$this->position_type->name];

        if ($this->status == 'Closed') {
            $data->Job_Opening_Status = "Cancelled";
        }

        $data->Subjects = [];
        foreach ($this->subjects as $subject) {
            $data->Subjects[] = $subject->name;
        }

        $fields->data[] = $data;
        $jsonData = $zohoRecruitAPI->updateRecord($fields, 'Job_Openings');

        return $this;
    }

    public function createTonJob()
    {
        $campus = $this->campus->primary_profile;

        $fields = [];
        $fields['position_type'] = $this->position_type->positionMap->ton;
        $fields['title'] = $this->title;
        $fields['summary'] = $this->title;
        $fields['content'] = $this->description.$this->responsibilities.$this->required_licences_certs;
        $fields['application_deadline'] = Carbon::create($this->expires_at)->format('Y-m-d');
        $fields['application_method'] = "EXTERNAL_SITE";
        $fields['application_method_instructions'] = $this->description;
        $fields['application_method_external_link'] = \URL::To('jobs/'.$this->url_slug);
        $fields['external_job_id'] = $this->id;

        /* School ID by City */
        $schoolID = 3532;

        switch ($campus->state) {
            case 'Australian Capital Territory':
            case 'New South Wales':
                $schoolID = 3532;
                break;

            case 'South Australia':
            case 'Tasmania':
            case 'Victoria':
                $schoolID = 3531;
                break;

            case 'Northern Territory':
            case 'Queensland':
            case 'Western Australia':
                $schoolID = 3468;
                break;
        }

        if (empty($schoolID)) {
            return false;
        }

        $fields['school_id'] = $schoolID;

        /* Job Contract */
        $jobType = 'CONTRACT POSITION';
        if ($this->job_length->name == 'Permanent') {
            $jobType = 'PERMANENT';
        }

        if ($this->job_length->name == 'Casual') {
            $jobType = 'CASUAL';
        }

        $fields['contractor_type'] = $jobType;

        /* Job Length */
        $fields['full_time_equivalence'] = "0.5";

        if ($this->employment_type == JobType::FULLTIME->value) {
            $fields['full_time_equivalence'] = "1.0";
        }

        /* Subjects */
        $fields['subjects'] = [];
        foreach ($this->subjects as $subject) {
            $fields['subjects'][] = $subject->subjectMap->ton;
        }

        $tonRest = new TeachersOnNetRest();
        $response = $tonRest->createJob($fields);

        return $this;
    }

    public function ehqTransformer()
    {
        $ehqJob = new \stdClass();
        $campus = $this->campus;

        /* Job Contract */
        $jobType = 'C';
        if ($this->job_length->name == 'Permanent') {
            $jobType = 'P';
        }

        if ($this->job_length->name == 'Casual') {
            $jobType = 'T';
        }

        /* Add SchoolHouse Link */
        $description = $this->description.$this->responsibilities.$this->required_licences_certs;
        $link = \URL::To('/jobs/'.$this->url_slug);
        $schoolhouseLink = "<br/><p><a href='$link'>Click here to visit Employo</a></p>";
        $description = $this->description.$schoolhouseLink;

        $ehqJob->school = $campus->school->name;
        $ehqJob->job_reference = "employo".$this->id;
        $ehqJob->job_title = $this->title;
        $ehqJob->job_type = $jobType;
        $ehqJob->job_hours = ($this->employment_type == JobType::FULLTIME->value) ? 'F' : 'P';
        $ehqJob->job_more_info = \URL::To('/jobs/'.$this->url_slug);
        $ehqJob->job_location = $campus->primary_profile->country.' / '.$campus->primary_profile->state.' / '.$campus->primary_profile->city;
        $ehqJob->job_description = $description;

        /* Position Type */
        $ehqJob->categories = [];

        $category = new \stdClass();
        $category->category_name = $this->position_type->positionMap->ehq;
        $ehqJob->categories[] = $category;

        /* Job Expires At */
        $expiresAt = new Carbon();
        if ($this->expires_at) {
            $expiresAt = new Carbon($this->expires_at);
        }

        $ehqJob->ad_expiry = $expiresAt->format('Y-m-d');

        /* School Type */
        $ehqJob->school_type = $campus->school->classification;
        if ($campus->school->classification == 'International') {
            $ehqJob->school_type = 'Other';
        }

        return $ehqJob;
    }

    public function indeedTransformer()
    {
        $indeedJob = [];
        $campus = $this->campus;

        $indeedJob['job']['title'] = $this->title;
        $indeedJob['job']['date'] = date('D, d M Y H:i:s e', strtotime('created_at'));
        $indeedJob['job']['referencenumber'] = 'employoindeed'.$this->id;
        $indeedJob['job']['requisitionid'] = $this->id;
        $indeedJob['job']['url'] = \URL::To('jobs/'.$this->url_slug);
        $indeedJob['job']['company'] = $campus->school->name;
        $indeedJob['job']['sourcename'] = $campus->school->name;
        $indeedJob['job']['city'] = $campus->primary_profile->city;
        $indeedJob['job']['state'] = $campus->primary_profile->state;
        $indeedJob['job']['country'] = $campus->primary_profile->country;
        $indeedJob['job']['postalcode'] = $campus->primary_profile->zipcode;
        $indeedJob['job']['streetaddress'] = $campus->primary_profile->address;
        $indeedJob['job']['email'] = '';
        $indeedJob['job']['job_description'] = $this->description.$this->responsibilities.$this->required_licences_certs;
        $indeedJob['job']['jobtype'] = $this->employment_type->value;
        $indeedJob['job']['expirationdate'] = date('D, d M Y H:i:s e', strtotime('expires_at'));

        return $indeedJob;
    }

    public function seekPositionProfileTransformer($categoryID, $locationID, $productID=null)
    {
        $employmentType = "FullTime";

        if ($this->employment_type == JobType::PARTTIME->value) {
            $employmentType = "PartTime";
        }

        /* Manage the Salary Type between Employo and SEEK */
        $salaryType = "Salaried";
        $intervalCode = "Year";
        $salaryMin = $this->salary_min;
        $salaryMax = $this->salary_max;

        switch ($this->salary_type) {
            case SalaryTypes::MONTHLY->value:
                $intervalCode = "Month";
                break;

            case SalaryTypes::HOURLY->value:
                $salaryType = "Hourly";
                $intervalCode = "Hour";
                break;

            case SalaryTypes::DAILY->value:
                /* Convert Daily Salary to Monthly */
                $salaryMin = $salaryMin * 22;
                $salaryMax = $salaryMax * 22;
                $intervalCode = "Month";
                break;
        }

        $positionProfile = [
            "jobCategories" => $categoryID,
            "positionLocation" => $locationID,
            "positionOrganizations" => env("SEEK_ORGANIZATION"),
            "positionTitle" => $this->title,
            "offeredRemunerationPackage" => [
                "basisCode" => $salaryType,
                "descriptions" => ["$this->salary_min - $this->salary_max"],
                "ranges" => [
                    [
                        "intervalCode" => $intervalCode,
                        "minimumAmount" => [ "currency" => "AUD", "value" => $salaryMin ],
                        "maximumAmount" => [ "currency" => "AUD", "value" => $salaryMax ]
                    ]
                ]
            ],
            "seekAnzWorkTypeCode" => $employmentType,
        ];

        if ($productID) {
            $positionProfile['postingInstructions'] = [
                "seekAdvertisementProductId" => $productID,
                "idempotencyId" => md5($this->created_at.$this->url_slug)
            ];
            $positionProfile['positionFormattedDescriptions'] = [
                [
                    "descriptionId" => "SearchSummary",
                    "content" => $this->description
                ],
                [
                    "descriptionId" => "AdvertisementDetails",
                    "content" => $this->description.$this->responsibilities.$this->required_licences_certs
                ]
            ];
        }

        return $positionProfile;
    }

    public function seekPositionOpeningTransformer($positionProfile)
    {
        $positionOpening = [
            "input" => [
                "positionOpening" => [
                    "postingRequester" => [
                        "roleCode" => "Company",
                        "id" => env("SEEK_ORGANIZATION"),
                        "personContacts" => [
                            [
                                "name" => ["formattedName" => "Tyson Wood"],
                                "roleCode" => "HiringManager",
                                "communication" => [
                                    "email" => [["address" => "tyson.wood@the-schoolhouse.com.au"]],
                                    "phone" => [["formattedNumber" => "+61 3 8007 2420"]]
                                ]
                            ]
                        ]
                    ],
                ],
                "positionProfile" => $positionProfile,
            ]
        ];

        return $positionOpening;
    }

    public function createSeekJob()
    {
        $seekAPI = new SeekGraph();
        $schemeID = 'seekAnz';

        /* Get Location */
        $campus = $this->campus->primary_profile;
        $location = $seekAPI->getNearestLocation($campus->latitude, $campus->longitude, $schemeID);

        /* Get Category ID mapped in the database */
        $category = $this->position_type->positionMap->seek;

        /* Create a Seek Position Profile Entity */
        $positionProfile = $this->seekPositionProfileTransformer($category, $location->data->nearestLocations[0]->id->value);

        /* Get the Dynamic Ad cost */
        $adSelections = $seekAPI->getAdSelections($positionProfile);

        /* Add the Costing on the Position Profile */
        $positionProfile = $this->seekPositionProfileTransformer($category, $location->data->nearestLocations[0]->id->value, $adSelections->data->advertisementProducts->products[0]->id->value);

        /* Create a Seek PositionOpening Entity */
        $positionOpening = $this->seekPositionOpeningTransformer($positionProfile);

        /* Post a Job */
        $jobPosition = $seekAPI->createJobPosition($positionOpening);
    }
}
