<?php

namespace App\Livewire\Search;

use App\Enums\EmptySearchTypes;
use App\Models\Campus;
use App\Models\Curriculum;
use App\Models\JobLength;
use App\Models\PositionTitle;
use App\Models\PositionType;
use App\Models\Religion;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class SchoolBoard extends TaxonomyFilterableComponent {

    #[Modelable]
    public string|null $search = null;

    public string|null $search_religion_filters = null;
    public string|null $search_curriculum_filters = null;

    public array $markers = [];

    public bool $display_map = true;

    /**
     * Lat / Lng bounds for the map
     *
     * @var array|null
     */
    public array|null $location_bounds = null;

    /**
     * Religions the user can filter too
     *
     * @var Collection
     */
    public Collection $religions;

    /**
     * Curricula the user can filter too
     *
     * @var Collection
     */
    public Collection $curricula;


    public $filters = [
        'early_childhood' => false,
        'primary' => false,
        'secondary' => false,
        'p_12' => false,
        'tertiary' => false,
        'co_ed' => false,
        'all_boys' => false,
        'all_girls' => false,
        'government' => false,
        'catholic' => false,
        'independent' => false,
        'religion' => [],
        'non_demominational' => false,
        'curricula' => [],
    ];


    public function mount(){
        $this->religions = Religion::all()->take(self::TAXONOMY_FILTER_RESULT_LIMIT);
        $this->curricula = Curriculum::all()->take(self::TAXONOMY_FILTER_RESULT_LIMIT);
    }

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

//        /**
//         * We cannot have both filters and search value at the same time as Scout (Meilisearch) does not like it.
//         */
//        if( $this->search ){
//            $this->search_value = null;
//        }

        $this->render();

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

        if( Str::startsWith( $field, 'filters' ) ){

            switch( Str::after( $field, '.' ) ){

                /**
                 * If we select one of the school types, we need to remove the other school types.
                 */
                case 'p_12':
                    $this->filters['secondary'] = false;
                    $this->filters['primary'] = false;
                    $this->filters['early_childhood'] = false;
                    $this->filters['tertiary'] = false;
                    break;

                case 'secondary':
                    $this->filters['p_12'] = false;
                    $this->filters['primary'] = false;
                    $this->filters['early_childhood'] = false;
                    $this->filters['tertiary'] = false;
                    break;

                case 'primary':
                    $this->filters['p_12'] = false;
                    $this->filters['secondary'] = false;
                    $this->filters['early_childhood'] = false;
                    $this->filters['tertiary'] = false;
                    break;

                case 'early_childhood':
                    $this->filters['p_12'] = false;
                    $this->filters['secondary'] = false;
                    $this->filters['primary'] = false;
                    $this->filters['tertiary'] = false;
                    break;

                case 'tertiary':
                    $this->filters['p_12'] = false;
                    $this->filters['secondary'] = false;
                    $this->filters['primary'] = false;
                    $this->filters['early_childhood'] = false;
                    break;

                /**
                 * If we select one of the school sex types, we need to remove the others.
                 */
                case 'co_ed':
                    $this->filters['all_boys'] = false;
                    $this->filters['all_girls'] = false;
                    break;

                case 'all_boys':
                    $this->filters['co_ed'] = false;
                    $this->filters['all_girls'] = false;
                    break;

                case 'all_girls':
                    $this->filters['all_boys'] = false;
                    $this->filters['co_ed'] = false;
                    break;


                /**
                 * If we select one of the school governance types, we need to remove the others.
                 */
                case 'government':
                    $this->filters['catholic'] = false;
                    $this->filters['independent'] = false;
                    break;

                case 'catholic':
                    $this->filters['government'] = false;
                    $this->filters['independent'] = false;
                    break;

                case 'independent':
                    $this->filters['government'] = false;
                    $this->filters['catholic'] = false;
                    break;

                /**
                 * If we select religion or non-denominational we need to remove the other.
                 */
                case 'non_demominational':
                    $this->filters['religion'] = [];
                    break;

            }

            // Handle Religion. Can't do this in the switch as it's an array. The key is something like 'filters.religion.1'
            if( Str::startsWith( $field, 'filters.religion' ) ){
                $this->filters['non_demominational'] = false;
            }

        }

        if( $field == 'search_religion_filters' ){
            $this->religions = $this->search_taxonomies_by_name(Religion::class, $value);
            $this->search_religion_filters = $value;
        }

        if( $field == 'search_curriculum_filters' ){
            $this->curricula = $this->search_taxonomies_by_name(Curriculum::class, $value);
            $this->search_curriculum_filters = $value;
        }

    }

    public function render() {

        $query = Campus::query();// ( $this->search_value ) ? Campus::search( $this->search_value ) : Campus::query();

        if( $this->search ){
            $query->whereHas( 'primary_profile', function( Builder $builder ){
                $builder
                    ->where( 'name', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'address', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'country', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'state', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'city', 'LIKE', '%' . $this->search . '%' )
                    ->orWhere( 'zipcode', 'LIKE', '%' . $this->search . '%' );
            } );
        } else {
            $query->whereHas( 'primary_profile' );
        }

        foreach( $this->filters as $key => $value ){
            switch( $key ){
                case 'early_childhood':
                    if( $this->filters['early_childhood'] ){
                        $query->whereHas( 'primary_profile.school_types', function( Builder $builder ){
                            $builder->where( 'name', 'Early Childhood' );
                        } );
                    }
                    break;
                case 'primary':
                    if( $this->filters['primary'] ){
                        $query->whereHas( 'primary_profile.school_types', function( Builder $builder ){
                            $builder->where( 'name', 'Primary (P-6)' );
                        } );
                    }
                    break;
                case 'secondary':
                    if( $this->filters['secondary'] ){
                        $query->whereHas( 'primary_profile.school_types', function( Builder $builder ){
                            $builder->where( 'name', 'Secondary (7-12)' );
                        } );
                    }
                    break;
                case 'p_12':
                    if( $this->filters['p_12'] ){
                        $query->whereHas( 'primary_profile.school_types', function( Builder $builder ){
                            $builder->where( 'name', 'Combined (P-12)' );
                        } );
                    }
                    break;
                case 'tertiary':
                    if( $this->filters['tertiary'] ){
                        $query->whereHas( 'primary_profile.school_types', function( Builder $builder ){
                            $builder->where( 'name', 'Tertiary' );
                        } );
                    }
                    break;
                case 'co_ed':
                    if( $this->filters['co_ed'] ){
                        $query->whereHas( 'primary_profile.genders', function( Builder $builder ){
                            $builder->where( 'name', 'Coeducational' );
                        } );
                    }
                    break;
                case 'all_boys':
                    if( $this->filters['all_boys'] ){
                        $query->whereHas( 'primary_profile.genders', function( Builder $builder ){
                            $builder->where( 'name', 'All Boys' );
                        } );
                    }
                    break;
                case 'all_girls':
                    if( $this->filters['all_girls'] ){
                        $query->whereHas( 'primary_profile.genders', function( Builder $builder ){
                            $builder->where( 'name', 'All Girls' );
                        } );
                    }
                    break;
                case 'government':
                    if( $this->filters['government'] ){
                        $query->whereHas( 'primary_profile.sectors', function( Builder $builder ){
                            $builder->where( 'name', 'Government' );
                        } );
                    }
                    break;
                case 'catholic':
                    if( $this->filters['catholic'] ){
                        $query->whereHas( 'primary_profile.sectors', function( Builder $builder ){
                            $builder->where( 'name', 'Catholic' );
                        } );
                    }
                    break;
                case 'independent':
                    if( $this->filters['independent'] ){
                        $query->whereHas( 'primary_profile.sectors', function( Builder $builder ){
                            $builder->where( 'name', 'Independent' );
                        } );
                    }
                    break;
                case 'religion':
                    if( ! empty( $this->filters['religion'] ) ){
                        $query->whereHas( 'primary_profile.religions', function( Builder $builder ){
                            $builder->whereIn( 'id', array_keys( $this->filters['religion'] ) );
                        } );
                    }
                    break;
                case 'non_demominational':
                    if( $this->filters['non_demominational'] ){
                        $query->whereHas( 'primary_profile.religions', function( Builder $builder ){
                            $builder->where( 'name', 'Non-denominational' );
                        } );
                    }
                    break;
                case 'curricula':
                    if( ! empty( $this->filters['curricula'] ) ){
                        $query->whereHas( 'primary_profile.curricula', function( Builder $builder ){
                            $builder->whereIn( 'id', array_keys( $this->filters['curricula'] ) );
                        } );
                    }
                    break;
            }
        }



        if( $this->location_bounds ){

            $query->whereHas( 'primary_profile', function( Builder $builder ){

                $polygon = new Polygon( [
                    new LineString([
                        new Point( $this->location_bounds['north'], $this->location_bounds['west'] ),
                        new Point( $this->location_bounds['north'], $this->location_bounds['east'] ),
                        new Point( $this->location_bounds['south'], $this->location_bounds['east'] ),
                        new Point( $this->location_bounds['south'], $this->location_bounds['west'] ),
                        new Point( $this->location_bounds['north'], $this->location_bounds['west'] ), // Last point must match the first point to complete a polygon.
                    ] )
                ] );

                $builder->whereWithin( 'location', $polygon );

            } );

        }

        $campuses = $query->take( 30 )->get();
        if ( $this->has_filters() && $campuses->isEmpty() ) {
            $this->report_empty_result(EmptySearchTypes::SCHOOL_SEARCH);
        }

        $this->markers = $campuses->map( function( $campus ){
            return [
                'latitude' => $campus->primary_profile?->latitude ?? 0,
                'longitude' => $campus->primary_profile?->longitude ?? 0,
                'id' => $campus->id,
            ];
        })->toArray();

        return view('livewire.search.school-board')->with([
            'campuses' => $campuses,
            'religions' => Religion::all(),
            'curricula' => Curriculum::all(),
        ]);

    }

}
