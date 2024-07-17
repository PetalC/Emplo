<?php

namespace App\Models;

use App\Enums\PlanFeatures;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends \LucasDotVin\Soulbscription\Models\Feature {

    use HasFactory;

    protected $fillable = [
        'consumable',
        'name',
        'periodicity_type',
        'periodicity',
        'quota',
        'postpaid',
    ];

//    protected $casts = [
//        'postpaid' => 'boolean',
////        'name' => PlanFeatures::class
//    ];

}
