<?php

namespace App\Nova\Actions;

use App\Facades\MapboxFacade as Mapbox;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class GetLatitudeLongitude extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        foreach( $models as $model ){

            if( $model->address && $model->city && $model->state && $model->zipcode && $model->country ){

                $results = Mapbox::search( $model->address . ' ' . $model->city . ' ' . $model->state . ' ' . $model->postcode . ' ' . $model->country );
                $model->latitude = $results[0]['latitude'];
                $model->longitude = $results[0]['longitude'];
                $model->save();

            }

        }

    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
