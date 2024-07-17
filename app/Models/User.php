<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Services\Linkedin;

/**
 * @property Profile $profile

 */
class User extends Authenticatable implements MustVerifyEmail {

    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'disabled',
        'phone_number',
    ];

    /**
     * The attributes that can be nullable
     */
    protected $nullable = [
        'phone_number',
        'data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'data' => AsArrayObject::class,
    ];

//    protected $appends = ['sg_data'];

    public function getNameAttribute() {
        return $this->first_name.' '.$this->last_name;
    }

    public function schools(){
        return $this->belongsToMany(School::class, 'school_user', 'user_id', 'school_id')->withPivot('flagged_at', 'flagged_by');
    }

    public function applications(){
        return $this->hasMany(Application::class, 'user_id');
    }

    public function profile(){
        return $this->hasOne(Profile::class );
    }

    public function referees(){
        return $this->hasMany(Referee::class, 'user_id');
    }

    public function certifications(){
        return $this->hasMany(Certification::class, 'user_id');
    }

    public function profile_certifications(){
        return $this->hasMany(UserProfileCertification::class, 'user_id');
    }

    public function followed_schools(){
        return $this->belongsToMany(Campus::class, 'campus_followers', 'user_id', 'campus_id' );
    }

    public function experiences(){
        return $this->hasMany(Experience::class, 'user_id');
    }

    public function educations(){
        return $this->hasMany(Education::class, 'user_id');
    }

    public function subjects(): \Illuminate\Database\Eloquent\Relations\MorphToMany {
        return $this->morphedByMany(
            Subject::class,
            'taxonomy',
            'user_taxonomies',
        );
    }

    public function preferred_position_types(): \Illuminate\Database\Eloquent\Relations\MorphToMany {
        return $this->morphedByMany(
            PositionType::class,
            'taxonomy',
            'user_taxonomies',
        )->wherePivot('category', 'preferred');
    }

    public function current_position_types(): \Illuminate\Database\Eloquent\Relations\MorphToMany {
        return $this->morphedByMany(
            PositionType::class,
            'taxonomy',
            'user_taxonomies',
        )->wherePivot('category', 'current');
    }

    public function preferred_job_lengths(): \Illuminate\Database\Eloquent\Relations\MorphToMany {
        return $this->morphedByMany(
            JobLength::class,
            'taxonomy',
            'user_taxonomies',
        );
    }

    public function preferred_school_types(): \Illuminate\Database\Eloquent\Relations\MorphToMany {
        return $this->morphedByMany(
            SchoolType::class,
            'taxonomy',
            'user_taxonomies',
        );
    }

    public function saved_jobs(){
        return $this->belongsToMany(Job::class, 'user_saved_job', 'user_id', 'job_id');
    }

    public function getSgDataAttribute(){

        $cacheKey = 'safeguarding_indicator_data_'.$this->id;

        if( cache()->has($cacheKey) ){
            //@TODO Turn this back on after demo, or when we feel like it
            //return cache()->get($cacheKey);
        }

        $data = [
            'suitability_declared' => $this->profile?->suitable_for_work ?? false,
            'references_supplied' => $this->referees()->exists(),
            'teaching_registration_verification' => $this->certifications()->where('is_valid', true )->exists(),
            'identity_verification' => false,
            'ancc_check' => false,
        ];

        cache()->put($cacheKey, $data, now()->addMinutes(5));

        return $data;

    }

    public function createLinkedInPost($content)
    {
        $linkedinAPI = new Linkedin;
        $access = $linkedinAPI->validateToken($this->id);
        
        if (empty($linkedinAPI->getAccessToken())) {
            return false;
        }
        
        $profile = $linkedinAPI->getProfile();
        
        if (!isset($profile->id)) {
            return false;
        }
        
        $fields = new \stdClass();
        $fields->author = "urn:li:person:".$profile->id;
        $fields->commentary = $content;
        $fields->visibility = 'PUBLIC';
        $fields->lifecycleState = 'PUBLISHED';
        $fields->isReshareDisabledByAuthor = false;

        $fields->distribution = new \stdClass();
        $fields->distribution->feedDistribution = "MAIN_FEED";
        
        return $linkedinAPI->insertRecord('posts', $fields);
    }
}
