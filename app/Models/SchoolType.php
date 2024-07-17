<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function campus_profiles(){
        return $this->morphToMany(
            CampusProfile::class,
            'taxonomy',
            'profile_taxonomies',
            'taxonomy_id',
            'campus_profile_id'
        );
    }

    public function users(){
        return $this->morphToMany(
            User::class,
            'taxonomy',
            'user_taxonomies',
            'taxonomy_id',
            'user_id'
        );
    }

}
