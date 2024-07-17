<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\MultiPolygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

/**
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property string $country_code
 * @property string $iso2
 * @property float $longitude
 * @property float $latitude
 * @property MultiPolygon $geometry
 */
class State extends Model
{

    use HasSpatial;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'country_id',
        'country_code',
        'iso2',
        'longitude',
        'latitude',
        'geometry',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'geometry' => MultiPolygon::class,
    ];

    public function country() {
        return $this->belongsTo(Country::class );
    }

}
