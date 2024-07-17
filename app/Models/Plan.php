<?php

namespace App\Models;

use App\Enums\PlanFeatures;
use App\Enums\PlanNames;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends \LucasDotVin\Soulbscription\Models\Plan
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'retail_price',
        'description',
        'grace_days',
        'periodicity_type',
        'periodicity',
    ];

    public function casts(){

        return array_merge( [
//            'name' => PlanNames::class,
            'retail_price' => 'float',
        ],  parent::casts() );

    }

//    public function

}
