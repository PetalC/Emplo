<?php

namespace App\Nova;

use App\Enums\PlanFeatures;
use App\Nova\Actions\FindLogo;
use App\Nova\Actions\GetLatitudeLongitude;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Subscription;

class Subscriptions extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<Subscription>
     */
    public static $model = Subscription::class;

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
        // Searching on school name would be nice, but have to do a subscriber to school join and not worth it for now
//        'school','plan'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
//
//        $name_options = [];
//
//        foreach( PlanFeatures::cases() as $case ){
//            $name_options[ $case->value ] = $case->value;
//        }


        return [
            ID::make()->sortable(),

            BelongsTo::make('School', 'subscriber' ),

            BelongsTo::make('Plan', 'plan' ),

            DateTime::make('Start Date', 'started_at' )->sortable(),
            DateTime::make('Expiry Date', 'expired_at' )->sortable(),

//            Badge::make('Status')
//                ->map(),

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
        ];
    }

//    public static function indexQuery(NovaRequest $request, $query) {
//
//        $query = $query->whereHas('listings.location.user', function ($builder) use ($user) {
//            return $builder->where('id', $user->id);
//        });
//
//        return $query;
//    }
}
