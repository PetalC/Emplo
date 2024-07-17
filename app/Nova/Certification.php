<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Enums\LicencingAuthorityTypes;

class Certification extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Certification>
     */
    public static $model = \App\Models\Certification::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
            BelongsTo::make('User', 'user', User::class)
                ->sortable()
                ->searchable()
                ->withoutTrashed()
                ->default($request->viaResourceId),
            Select::make('Licencing Authority', 'certification')
                ->options($this->getEnumOptions(LicencingAuthorityTypes::class))
                ->rules('required'),
            Text::make('Registration No', 'certification_id')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Expiry', 'expires_at')
                ->sortable()
                ->rules('required', 'max:255'),
            Boolean::make('Is Valid', 'is_valid')
                ->sortable()
                ->rules('required'),
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
        return [];
    }

    private function getEnumOptions($enumClass, $excludedCases = [])
    {
        $options = [];
        foreach (call_user_func(array($enumClass, 'cases')) as $case) {
            if (in_array($case, $excludedCases)) {
                continue;
            }
            $options[$case->value] = $case->value;
        }
        return $options;
    }
}
