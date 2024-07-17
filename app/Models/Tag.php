<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'specialization_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'label',
        'created_at'
    ];

}
