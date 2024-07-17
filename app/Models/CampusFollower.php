<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampusFollower extends Model
{
    use HasFactory;

    protected $table = 'campus_followers';

    protected $fillable = [
        'campus_id',
        'user_id',
        'type'
    ];

    public function campus() {
        return $this->belongsTo(Campus::class );
    }

    public function user() {
        return $this->belongsTo(User::class );
    }

}
