<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBoardSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'board_settings',
    ];

    protected function casts(): array
    {
        return [
            'board_settings' => 'array',
        ];
    }

    public function school() {
        return $this->belongsTo(School::class);
    }

}
