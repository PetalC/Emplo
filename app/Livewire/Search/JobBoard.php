<?php

namespace App\Livewire\Search;

use App\Enums\EmptySearchTypes;
use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Mail\EmptyJobSearchMail;
use App\Mail\EmptyTaxonomyFilterSearchMail;
use App\Models\Curriculum;
use App\Models\Job;
use App\Models\JobLength;
use App\Models\PositionTitle;
use App\Models\PositionType;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class JobBoard extends TaxonomyFilterableComponent {

    use WithoutUrlPagination, WithPagination;

    #[Modelable]
    public string|null $search = null;

    public string|null $search_position_filters = null;
    public string|null $search_subject_filters = null;
    public string|null $search_work_type_filters = null;
    public string|null $search_job_length_filters = null;
    public string|null $search_curriculum_filters = null;

    /**
     * Flag to show / hide the map.
     *
     * @var bool
     */
    public bool $display_map = true;

    /**
     * Lat / Lng bounds for the map
     *
     * @var array|null
     */
    public array|null $location_bounds = null;

    /**
     * Positions the user can filter to
     *
     * @var Collection
     */
    public Collection $positions;

    /**
     * Subjects the user can filter too
     *
     * @var Collection
     */
    public Collection $subjects;

    /**
     * Work Types the user can filter too
     *
     * @var Collection
     */
    public Collection $workTypes;

    /**
     * Job Lengths the user can filter too
     *
     * @var Collection
     */
    public Collection $lengths;

    /**
     * Curricula the user can filter too
     *
     * @var Collection
     */
    public Collection $curricula;

    /**
     * Location Types the user can filter too
     *
     * @var array
     */
    public array $location_types;

    public $filters = [
        'positions' => [],
        'subjects' => [],
        'work_types' => [],
        'length' => [],
        'curriculum' => [],
        'location_regional' => false,
        'location_coastal' => false,
        'location_metro' => false,
        'starting_soon' => false,
        'near_me' => false, //@TODO
        'relocation' => false,
        'housing' => false,
    ];

    public function mount(){
        $this->workTypes = collect( JobType::cases() );
        $this->subjects = Subject::all()->take(self::TAXONOMY_FILTER_RESULT_LIMIT); //CORRECT
        $this->lengths = JobLength::all()->take(self::TAXONOMY_FILTER_RESULT_LIMIT); //CORRECT
        $this->curricula = Curriculum::all()->take(self::TAXONOMY_FILTER_RESULT_LIMIT); //CORRECT
        $this->positions = PositionType::all()->take(self::TAXONOMY_FILTER_RESULT_LIMIT); //CORRECT
    }

    #[On('map_updated')]
    public function handleMapUpdated( $center, $bounds ){
        if( $bounds ){
            $this->location_bounds = [
                'north' => $bounds['_sw']['lat'],
                'east' => $bounds['_ne']['lng'],
                'south' => $bounds['_ne']['lat'],
                'west' => $bounds['_sw']['lng'],
            ];
        }
    }

    public function updated( $field, $value ){

        if( $field == 'search_position_filters' ){
            $this->positions = $this->search_taxonomies_by_name(PositionType::class, $value);
            $this->search_position_filters = $value;
        }

        if( $field == 'search_subject_filters' ){
            $this->subjects = $this->search_taxonomies_by_name(Subject::class, $value);
            $this->search_subject_filters = $value;
        }

//        if( $field == 'search_work_type_filters' ){
//            $this->workTypes = $this->search_taxonomies_by_name(PositionType::class, $value);
//            $this->search_work_type_filters = $value;
//        }

        if( $field == 'search_job_length_filters' ){
            $this->lengths = $this->search_taxonomies_by_name(JobLength::class, $value);
            $this->search_job_length_filters = $value;
        }

        if( $field == 'search_curriculum_filters' ){
            $this->curricula = $this->search_taxonomies_by_name(Curriculum::class, $value);
            $this->search_curriculum_filters = $value;
        }

    }



    public function setMapCenter( $latitude, $longitude ){
        $this->map_center = [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
    }

//    public function selectAddress( $key ){
//
////        $this->filters['near_me'] = true;
//
//        $this->dispatchBrowserEvent( 'setMapCenter', [
//            'latitude' => $this->user_address_results[$key]['latitude'],
//            'longitude' => $this->user_address_results[$key]['latitude'],
//        ] );
//
//    }

    #[Computed]
    public function has_filters(){

        $has_filters = false;

        if( $this->search ){
            $has_filters = true;
        }

        foreach ( $this->filters as $filter ){
            if( is_array( $filter ) && ! empty( $filter ) ){
                $has_filters = true;
            } else if( $filter === true ){
                $has_filters = true;
            }
        }

        return $has_filters;

    }

    public function toggleFilter( $filter, $id, $value ){

        if( is_bool( $this->filters[$filter] ) ){
            $this->filters[$filter] = ! $this->filters[$filter];
        } else {
			if( isset( $this->filters[$filter][$id] ) ){
				unset( $this->filters[$filter][$id] );
			} else {
				$this->filters[$filter][$id] = $value;
			}
		}
//        dd( $this->filters );

        /**
         * We cannot have both filters and search value at the same time as Scout (Meilisearch) does not like it.
         */
//        if( $this->search_value ){
//            $this->search_value = null;
//        }

    }

    public function removeFilter( $filter, $id ){

        if( $filter == 'search_value' ){
            // Search value. This is seperated from filters so it can be a URL parameter to link to a generic search.
            $this->search = null;
        } elseif( is_bool( $this->filters[$filter] ) ){
            // Boolean filters
            $this->filters[$filter] = false;
        } elseif( isset( $this->filters[$filter][$id] ) ){
            // Array filters
            unset( $this->filters[$filter][$id] );
        }

    }

    public function render(Request $request) {

//        if( $this->search_value ){
//            $jobs = Job::search( $this->search_value )
//                ->where( 'status', JobStatus::OPEN->value );
//        } else {
//
//        }

        $jobs = Job::with( 'campus' )
            ->where( 'status', JobStatus::OPEN )
            ->whereHas( 'campus.primary_profile' )
            ->latest( 'updated_at' );

        if( $this->search ){
            $jobs->where( 'title', 'LIKE', '%' . $this->search . '%' )
            ->orWhere( 'description', 'LIKE', '%' . $this->search . '%' )
            ->orWhereHas( 'campus.primary_profile', function( Builder $builder ){
                $builder->where( 'name', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'address', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'country', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'state', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'city', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'zipcode', 'LIKE', '%' . $this->search . '%' )
                ;
            });
        }

        // Default Orderby ID
        $jobs->orderBy( 'id', 'desc' );

        if( $this->filters['positions'] ){
            $jobs->whereIn( 'position_title_id', array_keys( $this->filters['positions'] ) );
        }

        if( $this->filters['subjects'] ){
            $jobs->whereHas( 'subjects', function( Builder $builder ){
                return $builder->whereIn( 'subjects.id', array_keys( $this->filters['subjects'] ) );
            });
        }

        if( $this->filters['work_types'] ){
            $jobs->whereIn( 'employment_type', array_keys( $this->filters['work_types'] ) );
        }

        if( $this->filters['length'] ){
            $jobs->whereIn( 'job_length_id', array_keys( $this->filters['length'] ) );
        }

        if( $this->filters['curriculum'] ){
            $jobs->whereHas( 'campus.primary_profile', function( Builder $builder ){
                return $builder->whereHas( 'curricula', function( Builder $builder ){
                    $builder->whereIn( 'curricula.id', array_keys( $this->filters['curriculum'] ) );
                }  );
            });
        }

        if( $this->filters['starting_soon'] ){
            $jobs->where( 'start_date', '<=', now()->addDays( 30 ) );
            $jobs->orderBy( 'start_date', 'desc' );
        }

        if( $this->filters['near_me'] ){
            $jobs->where( 'location_type_id', 1 );
        }

		if( $this->filters['location_regional'] ){
            $jobs->whereHas( 'campus.primary_profile', function( Builder $builder ){
                return $builder->whereHas( 'location_types', function( Builder $builder ){
                    $builder->where( 'name', 'Regional' );
                }  );
            });
		}

		if( $this->filters['location_coastal'] ){
            $jobs->whereHas( 'campus.primary_profile', function( Builder $builder ){
                return $builder->whereHas( 'location_types', function( Builder $builder ){
                    $builder->where( 'name', 'Coastal' );
                }  );
            });
		}

		if( $this->filters['location_metro'] ){
            $jobs->whereHas( 'campus.primary_profile', function( Builder $builder ){
                return $builder->whereHas( 'location_types', function( Builder $builder ){
                    $builder->where( 'name', 'Metropolitan' );
                }  );
            });
		}

        if( $this->filters['relocation'] ){
            $jobs->where( 'offers_relocation', true );
        }

        if( $this->filters['housing'] ){
            $jobs->where( 'offers_housing', true );
        }

        if( $this->location_bounds && $this->display_map ){

            $jobs->whereHas( 'campus', function( Builder $builder ){
                return $builder->whereHas( 'primary_profile', function( Builder $builder ){

                    $polygon = new Polygon( [
                        new LineString( [
                            new Point( $this->location_bounds['north'], $this->location_bounds['west'] ),
                            new Point( $this->location_bounds['north'], $this->location_bounds['east'] ),
                            new Point( $this->location_bounds['south'], $this->location_bounds['east'] ),
                            new Point( $this->location_bounds['south'], $this->location_bounds['west'] ),
                            new Point( $this->location_bounds['north'], $this->location_bounds['west'] ), // Last point must match the first point to complete a polygon.
                        ] )
                    ] );

                    $builder->whereWithin( 'location', $polygon );

                } );
            } );

        }

        $jobs = $jobs->take( 30 )->get();

        if ( $this->has_filters() && $jobs->isEmpty() ) {
            $this->report_empty_result(EmptySearchTypes::JOB_SEARCH);
        }

        $markers = $jobs->map( function( $job ){
            return [
                'latitude' => $job->campus->primary_profile?->latitude ?? 0,
                'longitude' => $job->campus->primary_profile?->longitude ?? 0,
                'id' => $job->id,
            ];
        })->toArray();

        return view('livewire.search.job-board', [
            'jobs' => $jobs,
            'markers' => $markers,
        ]);
    }

}
