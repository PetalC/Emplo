<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'school_gallery';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'school',
        'filename'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The School advertising the Job
     *
     * @return Profile
     */
    public function schoolDetails(): BelongsTo
    {
        return $this->belongsTo('App\Models\Profile', 'school');
    }

}