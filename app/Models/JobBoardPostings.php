<?php

namespace App\Models;

use App\Enums\JobBoardTypes;
use App\Observers\JobBoardPostingsObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(JobBoardPostingsObserver::class)]
class JobBoardPostings extends Model {
    use HasFactory;

    protected $fillable = [
        'job_id',
        'job_board',
        'url',
        'credit_cost',
        'is_posted',
        'posted_at',
        'posted_response'
    ];

    protected $casts = [
        'job_board' => JobBoardTypes::class,
        'posted_response' => 'array',
        'posted_at' => 'datetime',
        'is_posted' => 'boolean',
    ];

    public function job(){
        return $this->belongsTo(Job::class);
    }

}
