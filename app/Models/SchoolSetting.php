<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    use HasFactory;

    protected $table = 'school_settings';

    protected $fillable = [
        'school_id',
        'send_budget_reached',
        'send_new_candidate',
        'instagram',
        'twitter',
        'facebook',
        'linkedin',
    ];

    public function school() {
        return $this->hasOne(School::class);
    }

}
