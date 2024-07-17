<?php

namespace App\Models;

use App\Enums\PlanFeatures;
use App\Enums\PlanNames;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends \LucasDotVin\Soulbscription\Models\Subscription {
    use HasFactory;

    protected $appends = [
        'status',
    ];

    public function getStatusAttribute() {
        return 'test';
    }

}
