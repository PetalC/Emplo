<?php

namespace App\Livewire\Search;

use App\Facades\MapboxFacade;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Map extends Component
{

    /**
     * Variable to hold the address the user is searching for.
     *
     * @var string|null
     */
    public string|null $user_address_search = null;

    /**
     * Address results options for the user to select from.
     *
     * @var array|null
     */
    public array|null $user_address_results = null;

    /**
     * Radius the user is searching for jobs within.
     *
     * @var int
     */
    public $radius = 30;

    /**
     * Map has different functions for map ( Searches based on the bounds of the map, and can trigger a search when a map is moved )
     * or proximity, which searches based on a radius from a point
     *
     * @var bool
     */
    public $map_type_map = true;

    public array|null $map_center = null;

    public array|null $map_bounds = null;

    #[Reactive]
    public array $markers;

    public function mount() {

    }

    public function handleAddressSelection( $address ){

        $data = json_decode( $address, true );

        /**
         * array:4 [▼
         * "address" => "28 Presentation Boulevard, Nambour Queensland 4560, Australia"
         * "latitude" => -26.61255
         * "longitude" => 152.941551
         * "context" => array:6 [▶]
         * ]
         */

        $this->map_center = [ $data['longitude'], $data['latitude'] ];

        $this->dispatch( 'setMapCenter', [
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ] );

        $this->render();

    }

    public function updated( $field, $value ){

//        dd( 'MAP UPDATED' );

        if( $field == 'user_address_search' ){
            $this->geocodeAddress( $value );
        }

        if( $field === 'map_center' ){

            if( $this->map_type_map ){
                // This drives looking up jobs based on the map bounds
                $this->dispatch( 'map_updated', $this->map_center, $this->map_bounds );
            }

        }

    }

    public function geocodeAddress( $address ){

        $address = urlencode( $address );

        $addresses = MapboxFacade::search( $address );

        $this->user_address_results = $addresses;

    }



    public function render()
    {
        return view('livewire.search.map');
    }
}
