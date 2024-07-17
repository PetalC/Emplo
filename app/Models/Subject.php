<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
    use HasFactory;

    protected $fillable = ['name'];

    public function users() {
        return $this->morphToMany(
            User::class,
            'taxonomy',
            'profile_taxonomies',
            'taxonomy_id',
            'user_id'
        );
    }


    public function jobs() {
        return $this->morphToMany(
            Job::class,
            'taxonomy',
            'job_taxonomies',
            'taxonomy_id',
            'job_id'
        );
    }

    public function subjectMap() {
        return $this->hasOne(SubjectMap::class);
    }
}
