<?php

namespace App\Nova;

use App\Enums\MediaCollections;
use App\Enums\PlanFeatures;
use App\Nova\Actions\FindLogo;
use App\Nova\Actions\GetLatitudeLongitude;
use Elbgoods\NovaMapboxMarkerField\MapboxMarkerField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use LucasDotVin\Soulbscription\Enums\PeriodicityType;
use Mostafaznv\NovaMapField\Enums\MapSearchProvider;
use Mostafaznv\NovaMapField\Fields\MapMultiPolygonField;
use Mostafaznv\NovaMapField\Fields\MapPointField;

class Feature extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Campus>
     */
    public static $model = \App\Models\Feature::class;

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
    public static $group = 'Plans';

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

        $name_options = [];

        foreach( PlanFeatures::cases() as $case ){
            $name_options[ $case->value ] = $case->value;
        }


        return [
            ID::make()->sortable(),

            Select::make('Name')
                ->sortable()
                ->options( $name_options )
                ->rules('required', 'max:255'),

            Boolean::make( 'Consumable' ),

            Boolean::make( 'Quota' )->dependsOn(
                ['consumable'],
                function (Boolean $field, NovaRequest $request, FormData $formData) {
                    if ($formData->consumable) {
                        $field->hide();
                    }
                }
            ),

//            Boolean::make( 'Postpaid' ),

            Number::make( 'Periodicity' ),

            Select::make( 'Periodicity Type' )
                ->options( [
                    PeriodicityType::Day => PeriodicityType::Day,
                    PeriodicityType::Week => PeriodicityType::Week,
                    PeriodicityType::Month => PeriodicityType::Month,
                    PeriodicityType::Year => PeriodicityType::Year,
                ] ),

            HasMany::make('Plans', 'plans' ),

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
