<?php

namespace App\Livewire\School;

use App\Enums\MediaCollections;
use App\Facades\MapboxFacade;
use App\Models\Campus;
use App\Models\CampusProfile;
use App\Models\CitizenshipType;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use MatanYadaev\EloquentSpatial\Objects\Point;

class EditProfile extends Component
{

    use WithFileUploads;


    public string|TemporaryUploadedFile $logo_upload_file = '';

    public string|TemporaryUploadedFile $banner_upload = '';

    public string|TemporaryUploadedFile $gallery_upload = '';

//    public $document_upload;

    #[Locked]
    public CampusProfile|null $profile = null;

    #[Locked]
    public Campus $campus;

    public string $name;

    public ?int $student_enrollments;

    public ?int $staff_size;

    public ?int $teacher_size;

    public ?array $school_types;

    public ?array $school_genders;

    public ?array $school_sectors;

    public ?array $school_religions;

    public ?array $school_curricula;

    public ?array $school_location_types;

    public ?string $description;

    public ?string $quote;

    public ?string $proposition;

    public ?string $video_url;

    public ?string $address;

    public ?string $country;

    public ?string $state;

    public ?string $city;

    public ?string $zipcode;

    public ?string $branding_primary_color;
    public ?string $branding_secondary_color;
    public ?string $branding_tertiary_color;

//    public ?array $social_profiles = [
//        'facebook' => '',
//        'linkedin' => '',
//        'instagram' => '',
//    ];

//    public ?array $job_boards = [
//        'seek' => '',
//    ];

    public Collection $gallery_images;

    public string $address_search;

    public array $address_results;

    public function rules(){
        return [
            'name' => 'required|string',
            'logo_upload_file' => 'required|image|max:1024',
            'banner_upload' => 'required|image|max:3072',
            'gallery_upload' => 'required|image|max:2048',
            'student_enrollments' => 'required|integer',
            'staff_size' => 'required|integer',
            'teacher_size' => 'required|integer',
            'school_types' => 'required|array',
            'school_types.*' => 'sometimes|nullable|string',
            'school_genders' => 'required|array',
            'school_genders.*' => 'sometimes|nullable|string',
            'school_sectors' => 'required|array',
            'school_sectors.*' => 'sometimes|nullable|string',
            'school_religions' => 'required|array',
            'school_religions.*' => 'sometimes|nullable|string',
            'school_curricula' => 'required|array',
            'school_curricula.*' => 'sometimes|nullable|string',
            'school_location_types' => 'required|array',
            'description' => 'required|string|max:500',
            'quote' => 'required|string|max:150',
            'proposition' => 'required|string|max:1000',
            'video_url' => 'nullable|string|url',
//            'social_profiles' => 'required|array',
//            'social_profiles.*' => 'required|string',
//            'job_boards' => 'required|array',
//            'job_boards.*' => 'required|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'branding_primary_color' => 'sometimes|nullable|string',
            'branding_secondary_color' => 'sometimes|nullable|string',
            'branding_tertiary_color' => 'sometimes|nullable|string',
        ];
    }

    public function mount( ){

//        $this->authorize('update', $this->profile );

        if( ! $this->profile ){

            $this->redirect( route('school.campus_profile' ) );

//            $this->authorize('create', SchoolProfile::class );
//            $this->profile = new CampusProfile([
//                'campus_id' => $this->campus->id,
//                'name' => $this->campus->school->name,
//                'is_active' => 1,
//                'description' => '',
//                'proposition' => '',
//            ]);
//
//            $this->profile->save();
//
//            $this->redirect( route('school.campus_profile' ) );

        }


//        dd( $this->profile->sectors );

        /**
         * Prefill the data from the model
         */
        $this->name = $this->profile->name;
        $this->student_enrollments = $this->profile->student_enrollments;
        $this->staff_size = $this->profile->staff_size;
        $this->teacher_size = $this->profile->teacher_size;
        $this->school_types = $this->profile->school_types->pluck( 'name', 'id' )->toArray();
        $this->school_genders = $this->profile->genders->pluck( 'name', 'id' )->toArray();
        $this->school_sectors = $this->profile->sectors->pluck( 'name', 'id' )->toArray();
        $this->school_religions = $this->profile->religions->pluck( 'name', 'id' )->toArray();
        $this->school_curricula = $this->profile->curricula->pluck( 'name', 'id' )->toArray();
        $this->school_location_types = $this->profile->location_types->pluck( 'name', 'id' )->toArray();
        $this->description = $this->profile->description;
        $this->quote = $this->profile->quote;
        $this->proposition = $this->profile->proposition;
        $this->video_url = $this->profile->video_url;
//        $this->social_profiles = $this->profile->social_profiles;
//        $this->job_boards = $this->profile->job_boards;
        $this->address = $this->profile->address;
        $this->country = $this->profile->country;
        $this->state = $this->profile->state;
        $this->city = $this->profile->city;
        $this->zipcode = $this->profile->zipcode;
        $this->branding_primary_color = $this->profile->branding_primary_color;
        $this->branding_secondary_color = $this->profile->branding_secondary_color;
        $this->branding_tertiary_color = $this->profile->branding_tertiary_color;

//        if( ! $this->job_boards ){
//            $this->job_boards = [
//                'seek' => '',
//            ];
//        }
//
//        if( ! $this->social_profiles ){
//            $this->social_profiles = [
//                'facebook' => '',
//                'linkedin' => '',
//                'instagram' => '',
//            ];
//        }

    }

    public function geocodeAddress( $address ){

        $address = urlencode( $address );

        $addresses = MapboxFacade::search( $address );

        $this->address_results = $addresses;

    }

    public function handleAddressSelection( $address ){

        $data = json_decode( $address, true );

        $this->address = $data['context']['address']['name'];
        $this->country = $data['context']['country']['name'];
        $this->state = $data['context']['region']['name'];
        $this->city = $data['context']['locality']['name'];
        $this->zipcode = $data['context']['postcode']['name'];

        $this->address_results = [];
        $this->address_search = '';

        // Save the address to the database while we are here.
        $this->profile->latitude = $data['latitude'];
        $this->profile->longitude = $data['longitude'];
        $this->profile->location = new Point( $data['latitude'], $data['longitude'] );

        $this->saveProfile();

    }

    public function saveProfile(){
        $this->profile->address = $this->address;
        $this->profile->country = $this->country;
        $this->profile->state = $this->state;
        $this->profile->city = $this->city;
        $this->profile->zipcode = $this->zipcode;
        $this->profile->save();
    }

    public function updated( $field, $value ){

        $this->validateOnly( $field );

        //@TODO handle validation of parents for array fields EG school_types.* is validated above, but not the parent school_types


//        dd( $field, $value );

        switch( $field ){

            case 'logo_upload_file':

                /**
                 * Not having the field validated means it doesn't get hydrated into an UploadedFile instance. Too many hours here already
                 */

                $this->profile->clearMediaCollection( MediaCollections::CAMPUS_LOGO->value );

                $this->profile->addMedia( $this->logo_upload_file )->toMediaCollection( MediaCollections::CAMPUS_LOGO->value );

                break;

            case 'banner_upload':

                /**
                 * Not having the field validated means it doesn't get hydrated into an UploadedFile instance.
                 */

                $this->profile->clearMediaCollection( MediaCollections::CAMPUS_BANNER->value );

                $this->profile->addMedia( $this->banner_upload )->toMediaCollection( MediaCollections::CAMPUS_BANNER->value );

                break;

            case 'gallery_upload':

                /**
                 * Not having the field validated means it doesn't get hydrated into an UploadedFile instance.
                 */

                $this->profile->addMedia( $this->gallery_upload )->toMediaCollection( MediaCollections::CAMPUS_GALLERY->value );

                break;

            case 'name':
            case 'student_enrollments':
            case 'staff_size':
            case 'teacher_size':
            case 'description':
            case 'quote':
            case 'proposition':
            case 'video_url':
            case 'branding_primary_color':
            case 'branding_secondary_color':
            case 'branding_tertiary_color':
//                dd( $this->profile );
                $this->profile->{$field} = $value;
                $this->profile->save();
                break;

            case 'address':
            case 'country':
            case 'state':
            case 'city':
            case 'zipcode':

                if( $this->address && $this->country && $this->state && $this->city && $this->zipcode ){
                    $geocode = MapboxFacade::search( $this->address . ' ' . $this->city . ' ' . $this->state . ' ' . $this->country . ' ' . $this->zipcode );

                    if( isset( $geocode[0] ) ){
                        $this->profile->latitude = $geocode[0]['latitude'];
                        $this->profile->longitude = $geocode[0]['longitude'];
                        //location is updated from the observer
                    }

                }

                break;

            case 'address_search':
                $this->geocodeAddress( $value );
                break;

        }

        /**
         * Handle Arrays. $field is the full array EG social_profiles.facebook
         */
        if( Str::startsWith( $field, 'social_profiles' ) ){
            $this->profile->social_profiles = $this->social_profiles;
            $this->profile->save();
        }

        if( Str::startsWith( $field, 'job_boards' ) ){
            $this->profile->job_boards = $this->job_boards;
            $this->profile->save();
        }

        if( Str::startsWith( $field, 'school_types' ) ){
            $this->profile->school_types()->sync( array_keys( $this->school_types ) );
        }

        if( Str::startsWith( $field, 'school_genders' ) ){
            $this->profile->genders()->sync( array_keys( $this->school_genders ) );
        }

        if( Str::startsWith( $field, 'school_sectors' ) ){
            $this->profile->sectors()->sync( array_keys( $this->school_sectors ) );
        }

        if( Str::startsWith( $field, 'school_religions' ) ){
            $this->profile->religions()->sync( array_keys( $this->school_religions ) );
        }

        if( Str::startsWith( $field, 'school_curricula' ) ){
            $this->profile->curricula()->sync( array_keys( $this->school_curricula ) );
        }

        if( Str::startsWith( $field, 'school_location_types' ) ){
            $this->profile->location_types()->sync( array_keys( $this->school_location_types ) );
        }

        if( session()->has('current_campus') ){
            session()->put('current_campus', $this->campus->refresh() );
        }

    }

    public function deleteGalleryImage( $id ){
        $this->profile->media()->where( 'id', $id )->delete();
    }

    public function render() {
        return view('livewire.school.edit-profile');
    }

}
