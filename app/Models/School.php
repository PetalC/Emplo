<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Services\ZohoRecruit;
use LucasDotVin\Soulbscription\Models\Concerns\HasSubscriptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class School extends Model implements HasMedia {

    use HasFactory;
    use InteractsWithMedia;
    use HasSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'website',
    ];

    /**
     * Get all jobs
     */
    public function jobs(): HasMany {
        return $this->hasMany(Job::class);
    }

    public function campuses(): HasMany {
        return $this->hasMany(Campus::class)->whereNull( 'deleted_at' );
    }

    public function users(){
        return $this->belongsToMany(User::class, 'school_user', 'school_id', 'user_id' );
    }

    public function settings(){
        return $this->hasOne(SchoolSetting::class);
    }

    public function followers() {
        return $this->hasMany(CampusFollower::class);
    }

    public function primaryCampus(): HasOne {
        return $this->hasOne(Campus::class)->where('is_primary', 1 );
    }

    public function sector(){
        return $this->belongsTo(Sector::class);
    }

    public function flagged_users(){
        return $this->belongsToMany(User::class, 'school_user_flags', 'school_id', 'user_id' );
    }

    public function jobBoardSettings(){
        return $this->hasOne(JobBoardSettings::class);
    }

    public function createZohoRecruitSchool() {

        $zohoRecruitAPI = new ZohoRecruit();
        $fields = new \stdClass();

        $fields->data = [];
        $data = new \stdClass();
        $data->Client_Name = $this->name;
        $data->User_Status = "Non User";
        $data->Category = $this->classification;
        $data->Contact_Number = $this->phone;

        $campus = $this->primaryCampus;
        $campusProfile = null;

        if ($campus) {
            $campusProfile = $this->primary_profile;
        }

        if ($campusProfile) {
            $data->Billing_Country = $campusProfile->country;
            $data->Billing_State = $campusProfile->state;
            $data->Billing_City = $campusProfile->city;
            $data->Billing_Street = $campusProfile->address;
            $data->Billing_Code = $campusProfile->zipcode;
            $data->Territories = $campusProfile->city;
        }

        $fields->data[] = $data;
        $jsonData = $zohoRecruitAPI->insertRecord($fields, 'Clients');

        /* Save Zoho ID */
        $this->zoho_id = $jsonData->data[0]->details->id;
        $this->save();

        return $this;
    }
}
