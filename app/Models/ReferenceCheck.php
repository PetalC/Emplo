<?php

namespace App\Models;

use App\Enums\ApplicationReferenceCheckStatuses;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'ulid',
        'job_id',
        'referee_id',
        'candidate_id',
        'application_id',
        'status',
        'comment',
        'submitted_at',
        'completed_at',
        'position',
        'place_of_emplo',
        'work_with_date_start',
        'work_with_date_end',
        'child_protection_details',
        'performance_related_details',
        'reason_not_with_children_details',
        'recent_child_protection',
        'recommended_yes_details',
        'recommended_no_details',
        'rehire_yes_details',
        'rehire_no_details',
    ];

    protected $casts = [
        'status' => ApplicationReferenceCheckStatuses::class,
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
        'work_with_date_start' => 'datetime',
        'work_with_date_end' => 'datetime',
    ];

    public function referee()
    {
        return $this->belongsTo(Referee::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    protected function workWithDateStart(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Carbon::create($value)->format("d/j/Y")
        );
    }

    protected function workWithDateEnd(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Carbon::create($value)->format("d/j/Y")
        );
    }

}
