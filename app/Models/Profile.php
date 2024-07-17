<?php
namespace App\Models;

use App\Enums\MediaCollections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Services\ZohoRecruit;

class Profile extends Model implements HasMedia
{
    use SoftDeletes, HasFactory, InteractsWithMedia, HasSpatial;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'minimum_salary',
        'minimum_salary',
        'brief',
        'mobile_number',
        'alternate_number',
        'years_of_experience',
        'right_to_work',
        'suitable_for_work',
        'faith_reference'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'basic_information' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'suitable_for_work' => 'boolean',
        'right_to_work' => 'boolean',
        'faith_reference' => 'boolean',
        'minimum_salary' => 'float',
        'maximum_salary' => 'float',
        'location' => Point::class
    ];

    /**
     * The User associated with the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function citizenship(){
        return $this->belongsTo(CitizenshipType::class, 'citizenship_id' );
    }

    public function createZohoRecruitCandidate($marketingOptOut=false)
    {
        $zohoRecruitAPI = new ZohoRecruit();
        $fields = new \stdClass();

        $fields->data = [];
        $data = new \stdClass();
        $data->First_Name = $this->account->firstname;
        $data->Last_Name = $this->account->lastname;
        $data->SchoolHouse_Category = ["Teachings"]; // TODO: Get Categories

        /* Insert Subject Specializations */
        $data->Subject_Specialisation = [];

        foreach ($this->specializations as $specialization) {
            $data->Subject_Specialisation[] = $specialization->label;
        }

        $data->Preferred_Location = [$this->city];
        $data->Date_Available = Carbon::parse($this->created_at)->format('Y-m-d');
        $data->Secondary_Source = 'Employo Recruitment Portal';
        $data->City = $this->city;
        $data->State = $this->state;
        $data->Country = $this->country;
        $data->Zip_Code = $this->zipcode;
        $data->Mobile = $this->mobile_number;
        $data->Email = $this->account->email;

        $data->Website_Terms_of_Use = true;
        $data->Recruitment_Opt_Out_af_Signup = false;

        if ($marketingOptOut) {
            $data->Recruitment_Opt_Out_af_Signup = true;
        }

        if ('test' == env('APP_ENV')) {
            $data->First_Name = 'Test Candidate - '.$data->First_Name;
        }

        $fields->data[] = $data;
        $jsonData = $zohoRecruitAPI->insertRecord($fields, 'Candidates');

        /* Save Zoho ID */
        $this->zoho_id = $jsonData->data[0]->details->id;
        $this->save();

        return $this;
    }

    public function updateZohoRecruitCandidateCV()
    {
        $zohoRecruitAPI = new ZohoRecruit();
        $fields = new \stdClass();

        $fields->data = [];
        $data = new \stdClass();
        $data->id = $this->zoho_id;
        $data->CV = \URL::To('uploads/resume/'.$this->curriculum_vitae);

        $fields->data[] = $data;
        $jsonData = $zohoRecruitAPI->updateRecord($fields, 'Candidates');

        return $this;
    }
}
