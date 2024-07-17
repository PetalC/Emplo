<?php
namespace App\Models;

use App\Enums\MediaCollections;
use App\Observers\CampusProfileObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(CampusProfileObserver::class)]
class CampusProfile extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory, HasSpatial;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campus_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'campus_id',
        'name',
        'classification',
        'description',
        'proposition',
        'quote',
        'student_enrollments',
        'staff_size',
        'teacher_size',
        'video_url',
        'is_active',
        'branding_color_primary',
        'branding_color_secondary',
        'branding_color_tertiary',
        'latitude',
        'longitude',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'closed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'location' => Point::class
    ];

    protected $appends = [
        'full_address',
        'banner_image'
    ];


    public function getFullAddressAttribute(){
        return join(', ', array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->country,
        ]));
    }

    public function getShortAddressAttribute(){
        return join(', ', array_filter([
            $this->city,
            $this->state,
            $this->country,
        ]));
    }

    public function getBannerImageAttribute(){

        if( $this->hasMedia(MediaCollections::CAMPUS_BANNER->value) ){

            if( ! App::environment('local' ) ){
                return $this->getFirstTemporaryUrl( now()->addMinutes( 5 ), MediaCollections::CAMPUS_BANNER->value );
            }

            return $this->getFirstMediaUrl( MediaCollections::CAMPUS_BANNER->value );

        }

        return false;

    }

    public function campus(){
        return $this->belongsTo(Campus::class);
    }

    public function sectors(): MorphToMany {
        return $this->morphedByMany(
            Sector::class,
            'taxonomy',
            'profile_taxonomies',
        );
    }

    public function curricula(): MorphToMany {
        return $this->morphedByMany(
            Curriculum::class,
            'taxonomy',
            'profile_taxonomies',
        );
    }

    public function genders(): MorphToMany {
        return $this->morphedByMany(
            SchoolGender::class,
            'taxonomy',
            'profile_taxonomies',
        );
    }

    public function religions(): MorphToMany {
        return $this->morphedByMany(
            Religion::class,
            'taxonomy',
            'profile_taxonomies',
        );
    }

    public function school_types(): MorphToMany {
        return $this->morphedByMany(
            SchoolType::class,
            'taxonomy',
            'profile_taxonomies',
        );
    }

    public function location_types(): MorphToMany {
        return $this->morphedByMany(
            LocationType::class,
            'taxonomy',
            'profile_taxonomies',
        );
    }

    public function setColors(){
        config()->set('school.color-primary', $this->branding_primary_color );
        config()->set('school.color-secondary', $this->branding_secondary_color );
        config()->set('school.color-tertiary', $this->branding_tertiary_color );
    }

    /**
     * Attempt to find the logo for the campus using google places.
     *
     * 1. Search for the campus in google places
     * 2. Get the place details
     * 3. Get the domain of the URL
     * 4. Get the file from Clearbit
     * 5. Get the mime type of the file
     * 6. Get the extension of the file
     * 7. Save the file to the media collection
     *
     * @throws \Exception
     * @return bool|void
     */
    public function findLogo(){

        if( $this->hasMedia(MediaCollections::CAMPUS_LOGO->value ) ){
            throw new \Exception('This campus already has a logo. Aborting.' );
        }

        // Search for the campus in google places
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=' . urlencode( $this->name ) . '&key=' . env( 'GOOGLE_MAPS_API_KEY' );

        $search_response = Http::get( $url );

        $json = json_decode( $search_response->body(), true );

        if( empty( $json ) ){
            throw new \Exception('No result from google places.' );
        }

        // Get the place details
        $url = 'https://places.googleapis.com/v1/places/' . $json['results'][0]['place_id'] . '?fields=websiteUri&key=' . env( 'GOOGLE_MAPS_API_KEY' );

        $place_request = Http::get( $url );

        $json = json_decode( $place_request->body(), true );

        if( $json && isset( $json['websiteUri'] ) ){
            $url = $json['websiteUri'];
        } else {
            throw new \Exception('No website found in google places');
        }

        // Get the domain of the URL
        $domain = parse_url( $url, PHP_URL_HOST );

        // Get the file from Clearbit
        $file = Http::get( 'https://logo.clearbit.com/' . $domain );

        if( ! $file->ok() && ! $file->body() == "\n" ){
            throw new \Exception('No file found on Clearbit. Domain - ' . $domain );
        }

        // Get the mime type of the file
        $mime = finfo_buffer( finfo_open( FILEINFO_MIME_TYPE ), $file->body() );

        if( Str::contains(  $mime, 'image' ) ){

            // Get the extension of the file
            $extension = Str::after( $mime, '/' );

            if( $extension ){
                $this->clearMediaCollection( MediaCollections::CAMPUS_LOGO->value );
                $this->addMediaFromString( $file->body() )->setFileName( 'logo.' . $extension )->toMediaCollection( MediaCollections::CAMPUS_LOGO->value );
            }

            return true;

        } else {
            throw new \Exception('Image Mime type is invalid. Domain is ' . $domain . ' and mime is ' . $mime );
        }

    }

}
