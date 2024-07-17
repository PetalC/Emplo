<?php

namespace App\Nova;

use Laravel\Nova\Fields\Text;

class PlanFeatureFields {

    /**
     * Get the pivot fields for the relationship.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $relatedModel
     * @return array
     */
    public function __invoke($request, $relatedModel) {
        return [
            Text::make('Charges' ),
        ];
    }

}
