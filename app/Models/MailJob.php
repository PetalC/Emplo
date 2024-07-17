<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailJob extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'email_queue';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'sender',
        'classification',
        'title',
        'content',
        'recipient',
        'status'
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

}
