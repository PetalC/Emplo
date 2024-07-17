<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'school_invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'school',
        'job',
        'zoho_books_id',
        'zoho_books_url',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * The attributes that are added to the collections.
     *
     * @var array
     */
    protected $appends = ['payment_status'];

    /**
     * The School that is billed
     *
     * @return User
     */
    public function schoolDetails(): BelongsTo
    {
        return $this->belongsTo( 'App\Models\CampusProfile', 'school');
    }

    /**
     * The Job posted that is paid for
     *
     * @return User
     */
    public function jobDetails(): BelongsTo
    {
        return $this->belongsTo('App\Models\Advert', 'job');
    }

    /**
     * The Status of the invoice
     *
     * @return User
     */
    public function getPaymentStatusAttribute()
    {
        if (empty($this->paid_at)) {
            return 'Pending';
        }

        return 'Paid';
    }
}
