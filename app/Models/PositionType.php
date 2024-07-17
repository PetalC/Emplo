<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function jobs() {
        return $this->hasMany(Job::class );
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

    public function positionMap() {
        return $this->hasOne(PositionMap::class);
    }

}
