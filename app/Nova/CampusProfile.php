<?php

namespace App\Nova;

use App\Enums\MediaCollections;
use App\Nova\Actions\FindLogo;
use App\Nova\Actions\GetLatitudeLongitude;
use Elbgoods\NovaMapboxMarkerField\MapboxMarkerField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Mostafaznv\NovaMapField\Enums\MapSearchProvider;
use Mostafaznv\NovaMapField\Fields\MapMultiPolygonField;
use Mostafaznv\NovaMapField\Fields\MapPointField;

class CampusProfile extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Campus>
     */
    public static $model = \App\Models\CampusProfile::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Schools';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name','description'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Image::make('Logo')
                ->store(function (Request $request, $model) {
                    $model->clearMediaCollection( MediaCollections::CAMPUS_LOGO->value );
                    $model->addMediaFromRequest('logo')->toMediaCollection( MediaCollections::CAMPUS_LOGO->value );
                    return true;
                })
                ->preview(function () {
                    if( env('APP_ENV') != 'local' ){
                        return $this->getFirstTemporaryUrl( now()->addMinutes( 5 ), MediaCollections::CAMPUS_LOGO->value );
                    }
                    return $this->getFirstMediaUrl( MediaCollections::CAMPUS_LOGO->value );
                })
                ->thumbnail(function () {
                    if( env('APP_ENV') != 'local' ){
                        return $this->getFirstTemporaryUrl( now()->addMinutes( 5 ), MediaCollections::CAMPUS_LOGO->value );
                    }
                    return $this->getFirstMediaUrl( MediaCollections::CAMPUS_LOGO->value );
                })
                ->delete(function ( Request $request, $model ) {
                    $model->clearMediaCollection( MediaCollections::CAMPUS_LOGO->value );
                    return true;
                })
                ->deletable(true ),
            BelongsTo::make('Campus', 'campus', Campus::class)
                ->sortable()
                ->searchable()
                ->withoutTrashed()
                ->default($request->viaResourceId)
                ->displayUsing(function ($campus) {
                    return $campus->primary_profile?->name ?? $campus->school->name;
                }),
            Boolean::make( 'Is Active', 'is_active' )
                ->sortable()
                ->default( true ),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Quote')
                ->rules('required', 'max:150'),

            Textarea::make('Description')
                ->onlyOnForms()
                ->nullable()
                ->rules( 'sometimes', 'nullable', 'max:1000' ),

            Textarea::make('Proposition')
                ->nullable()
                ->onlyOnForms()
                ->rules( 'sometimes', 'nullable', 'max:1000' ),

            MapPointField::make('Location')
                ->hideFromIndex()
                ->showOnUpdating()
                ->zoom( 8 ),
            Text::make('Latitude')
                ->onlyOnForms()
                ->sortable()
                // Latitude validation @see https://stackoverflow.com/questions/47184526/validating-latitude-longitude-in-laravel-validation-regex-rule-preg-match-n
                ->rules('required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'),
            Text::make('Longitude')
                ->onlyOnForms()
                ->sortable()
                // Longitude validation @see https://stackoverflow.com/questions/47184526/validating-latitude-longitude-in-laravel-validation-regex-rule-preg-match-n
                ->rules('required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'),

            Text::make('Address')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('City')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('State')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Zip', 'zipcode')
                ->sortable()
                ->rules('required', 'max:10'),
            Text::make('Country', 'country')
                ->sortable()
                ->nullable(),

            MorphedByMany::make('Genders', 'genders', Gender::class ),
            MorphedByMany::make('Sectors', 'sectors', Sector::class ),
            MorphedByMany::make('Curricula', 'curricula', Curriculum::class ),
            MorphedByMany::make('Religions', 'religions', Religion::class ),
            MorphedByMany::make('School Types', 'school_types', SchoolType::class ),
            MorphedByMany::make('Location Types', 'location_types', LocationType::class ),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            GetLatitudeLongitude::make(),
            FindLogo::make(),
        ];
    }
}
