<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MapboxFacade extends Facade {
    protected static function getFacadeAccessor() {
        return 'mapbox';
    }

}
