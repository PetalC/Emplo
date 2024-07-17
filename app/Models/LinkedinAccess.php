<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedinAccess extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'linkedin_access';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user',
        'access_token',
        'expires_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

}