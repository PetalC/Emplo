<?php

namespace App\View\Components\App\Navigation;

use Illuminate\View\Component;

class Responsive extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.app.navigation.responsive')->with( [
//            'currentRoute' => request()->route()->getName()
        ]);
    }

}
