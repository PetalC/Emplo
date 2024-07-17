<?php

namespace App\Models;

use App\Enums\ApplicationReviewStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Review extends Model {
    use HasFactory;

    protected $fillable = [
        'application_id',
        'member_id',
        'status',
    ];

    //         {{-- @Nate - Merge conflict - unsure about application review status enu,, need to dig into it --}}
    protected $casts = [
        'status' => ApplicationReviewStatuses::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function application(){
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function member(){
        return $this->belongsTo(User::class, 'member_id');
    }

}
