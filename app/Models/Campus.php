<?php
namespace App\Models;

//use Laravel\Scout\Searchable;
use App\Enums\JobStatus;
use App\Enums\MediaCollections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Campus extends Model implements HasMedia {

    //use Searchable;
    use SoftDeletes;
    use HasFactory;
    use InteractsWithMedia;
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'school_id',
        'url_slug',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = ['name', 'banner_image'];

//    protected static function booted(): void {
//
////        dump( 'Campus booted' );
////
////        dump( session()->get('current_school') );
//
//        // If there is a current school in the session, apply a global scope
//        if( session()->has('current_school') ){
//            static::addGlobalScope('school', function ($query) {
//                $query->where('school_id', session()->get('current_school')->id);
//            });
//        }
//
//    }

//    /**
//     * Get the indexable data array for the model.
//     *
//     * @return array
//     */
//    public function toSearchableArray() {
//        $array = $this->toArray();
//        $array['_geoloc']['lat'] = (float)$this->latitude;
//        $array['_geoloc']['lng'] = (float)$this->longitude;
//
//        // Customize array...
//
//        return $array;
//    }

    public function jobs() {
        return $this->hasMany(Job::class);
    }

    public function latest_jobs() {
        return $this->jobs()->where( 'status', JobStatus::OPEN )->latest()->limit(5);
    }

    /**
     * The School profiles
     */
    public function profiles(): HasMany {
        return $this->hasMany(CampusProfile::class, 'campus_id', 'id' );
    }

    public function primary_profile(): HasOne {
        return $this->hasOne( CampusProfile::class, 'campus_id', 'id' )->where( 'is_active', 1 );
    }


    public function school(): BelongsTo {
        return $this->belongsTo(School::class);
    }

    public function followers(): BelongsToMany {
        return $this->belongsToMany(User::class, 'campus_followers', 'campus_id', 'user_id');
    }

    /**
     * School Settings
     */
    public function settings(): HasOne {
        return $this->hasOne(Setting::class, 'school');
    }

    public function getNameAttribute(){
        return $this->city . ', ' . $this->state;
    }

    public function getBannerImageAttribute(){

        if( $this->primary_profile()->exists() ){

            if( ! App::environment('local' ) ){
                return $this->primary_profile->getFirstTemporaryUrl( now()->addMinutes( 5 ), MediaCollections::CAMPUS_BANNER->value );
            }
            return $this->primary_profile->getFirstMediaUrl(MediaCollections::CAMPUS_BANNER->value);

        }

        return '';

    }

    public function getRouteKeyName(): string {
        return 'uuid';
    }

    public function toSearchableArray() {
        $array = $this->toArray();
        $array['_geoloc']['lat'] = (float)$this->primary_profile?->latitude ?? 0;
        $array['_geoloc']['lng'] = (float)$this->primary_profile?->longitude ?? 0;

        // Need these here to handle the search results. Scout doesn't handle whereHas or whereBetween queries....
        $array['latitude'] = $this->primary_profile?->latitude ?? 0;
        $array['longitude'] = $this->primary_profile?->longitude ?? 0;
        $array['name'] = $this->primary_profile?->name ?? '';

        return $array;
    }

}
