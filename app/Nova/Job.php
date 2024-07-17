<?php

namespace App\Nova;

use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\LicencingAuthorityTypes;
use App\Enums\SalaryTypes;
use App\Enums\VacancyReasons;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Job extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Job>
     */
    public static $model = \App\Models\Job::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Jobs';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'description', 'responsibilities', 'required_licences_certs', 'salary'
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

            BelongsTo::make('School', 'school')->withoutTrashed()
                ->searchable()
                ->sortable(),

            BelongsTo::make('Campus', 'campus')->withoutTrashed()
                ->displayUsing(function($campus) {
                    return $campus->primary_profile?->name ?? 'Campus has no primary profile.';
                } )
                ->searchable()
                ->sortable(),

            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255')
                ->displayUsing(function($text) {
                    return Str::limit($text, 35);
                }),

            Text::make('URL Slug')
                ->sortable()
                ->rules('required', 'max:255'),

            Textarea::make('Description' )
                ->rules('required', 'max:1000' )
                ->displayUsing(function($text) {
                    return Str::limit( $text, 1000 );
                }),

            Trix::make('Responsibilities')
                ->rules('required'),


            Select::make('Status')
                ->options($this->getEnumOptions(JobStatus::class, [JobStatus::CANCELLED])),

            Select::make('Licencing Authority')
                ->options($this->getEnumOptions(LicencingAuthorityTypes::class))
                ->rules('required'),

            Number::make('Salary Min')
                ->sortable()
                ->rules('sometimes', 'min:0'),

            Number::make('Salary Max')
                ->sortable()
                ->rules('sometimes', 'gt:salary_min'),

            Select::make('Salary Type')
                ->options($this->getEnumOptions(SalaryTypes::class))
                ->rules('required'),

            Boolean::make('Offers Relocation')
                ->sortable(),

            Boolean::make('Offers Housing')
                ->sortable(),

            Select::make('Employment Type')
                ->options($this->getEnumOptions(JobType::class))
                ->rules('required'),

            Select::make('Vacancy Reason')
                ->options($this->getEnumOptions(VacancyReasons::class))
                ->rules('required'),

            BelongsTo::make('Position Type', 'position_type' )
                ->searchable()
                ->sortable(),

            BelongsTo::make('Job Length', 'job_length' )
                ->searchable()
                ->sortable(),

            Boolean::make('Recommended')
                ->sortable(),

            HasMany::make('Subjects')->sortable(),
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
