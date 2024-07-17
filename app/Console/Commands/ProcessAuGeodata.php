<?php

namespace App\Console\Commands;

use App\Facades\MapboxFacade as Mapbox;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use MatanYadaev\EloquentSpatial\Objects\MultiPolygon;

class ProcessAuGeodata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:process-au-geodata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the AU geodata data set for states';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $data = json_decode( file_get_contents( storage_path( 'data/australia_states.geojson' ) ), true );

        foreach( $data['features'] as $feature ){

            $state = State::where( 'iso2', $feature['properties']['ste_iso3166_code'] )->first();

            if( ! $state ){
                $this->error( 'Could not find State ' . $feature['properties']['ste_iso3166_code'] );
                continue;
            }

            $this->info( 'Processing State ' . $state->name );

            $json = json_encode( $feature['geometry'] );

            switch( $feature['geometry']['type'] ){
                case 'Polygon':
                    $polygon = \MatanYadaev\EloquentSpatial\Objects\Polygon::fromJson( $json );
                    $multipolygon = new \MatanYadaev\EloquentSpatial\Objects\MultiPolygon( [ $polygon ] );
                    break;
                case 'MultiPolygon':
                    $multipolygon = \MatanYadaev\EloquentSpatial\Objects\MultiPolygon::fromJson( $json );
                    break;
                default:
                    $multipolygon = null;
                    $this->error( 'Could not create MultiPolygon for ' . $state->name );
                    return;
            }

            try{
                $state->geometry = $multipolygon;
                $state->save();
            } catch( \Exception $e ){
                $this->error( 'Could not save MultiPolygon for ' . $state->name );
                $this->error( $e->getMessage() );
                continue;
            }

        }

    }

}
