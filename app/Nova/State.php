<?php

namespace App\Nova;

use App\Nova\Actions\GetStateLatitudeLongitude;
use Elbgoods\NovaMapboxShapeField\MapboxShapeField;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use Mostafaznv\NovaMapField\Fields\MapMultiPolygonField;

class State extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Subject>
     */
    public static $model = \App\Models\State::class;

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
    public static $group = 'Taxonomies';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name'
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
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Latitude')
                ->sortable()
                // Latitude validation @see https://stackoverflow.com/questions/47184526/validating-latitude-longitude-in-laravel-validation-regex-rule-preg-match-n
                ->rules('required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'),
            Text::make('Longitude')
                ->sortable()
                // Longitude validation @see https://stackoverflow.com/questions/47184526/validating-latitude-longitude-in-laravel-validation-regex-rule-preg-match-n
                ->rules('required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'),

            MapMultiPolygonField::make( 'Geometry' )
                ->hideDetailButton()
            ->hideFromIndex(),

        ];
    }

    public function getGeoJson(): array
    {

        if ($this->geometry) {
            return $this->geometry->toArray();
        }

        return [
            'type'        => 'Polygon',
            'coordinates' => [[
                  [$this->longitude - 0.5, $this->latitude - 0.5],
                  [$this->longitude + 0.5, $this->latitude - 0.5],
                  [$this->longitude + 0.5, $this->latitude + 0.5],
                  [$this->longitude - 0.5, $this->latitude + 0.5],
            ]],
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
            GetStateLatitudeLongitude::make(),
        ];
    }
}
