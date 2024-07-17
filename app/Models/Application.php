<?php

namespace App\Models;

use App\Enums\ApplicationStatuses;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * A candidates submission for a job
 */
class Application extends Model implements HasMedia {
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ulid',
        'job_id',
        'campus_id',
        'user_id',
        'specialities',
        'registration',
        'right_to_work',
        'current_occupation',
        'job_type',
        'referred_method',
        'shortlisted_at',
        'declined_at',
        'hired_at',
        'references_requested_at',
        'status',
        'save_details',
        'suitable_declared',
        'validated_step',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'specialities' => 'array',
        'registration' => 'array',
        'status' => ApplicationStatuses::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'shortlisted_at' => 'datetime',
        'hired_at' => 'datetime',
        'references_requested_at' => 'datetime',
        'declined_at' => 'datetime',
        'save_details' => 'boolean',
        'suitable_declared' => 'boolean',
    ];

    public function job(){
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function campus(){
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reference_checks() {
        return $this->hasMany(ReferenceCheck::class);
    }

//    public function interviews() {
//        return $this->hasMany(Interview::class );
//    }

    public function interview() {
        return $this->hasOne(Interview::class );
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function getIsFlaggedAttribute()
    {
        // Flagging applications 5% of the time
        return rand(0,100) > 95;
        return $this->user->schools->first()->pivot->flagged_at !== null;
    }

}
