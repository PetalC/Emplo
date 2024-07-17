<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Interview extends Model implements HasMedia {

    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'type',
        'link',
        'panel_members',
        'status',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'panel_members' => 'array',
    ];

    public function application(){
        return $this->belongsTo(Application::class);
    }

}
