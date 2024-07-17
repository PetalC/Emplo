<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The Mapping of Specialization Tags to
 * Third-party Job Boards
 */
class SubjectMap extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject_id',
        'ton',
        'ehq',
        'seek',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
