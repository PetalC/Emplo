<?php
namespace App\Models;

use App\Enums\LicencingAuthorityTypes;
use App\Observers\CertificationsObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy( CertificationsObserver::class)]
class Certification extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_certifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'certification',
        'certification_id',
        'is_valid',
        'expires_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'certification' => LicencingAuthorityTypes::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The User associated with the certification
     */
    public function user() {
        return $this->belongsTo(User::class );
    }

}
