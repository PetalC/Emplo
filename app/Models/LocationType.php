<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function jobs() {
        return $this->hasMany(Job::class );
    }

    public function campus_profiles(){
        return $this->morphToMany(
            CampusProfile::class,
            'taxonomy',
            'profile_taxonomies',
            'taxonomy_id',
            'campus_profile_id'
        );
    }

}
