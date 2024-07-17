<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PositionType;

/**
 * The Mapping of Specialization Tags to
 * Third-party Job Boards
 */
class PositionMap extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'position_type_maps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'position_id',
        'ton',
        'ehq',
        'seek',
    ];

    public function position()
    {
        return $this->belongsTo(PositionType::class, 'position_id');
    }
}
