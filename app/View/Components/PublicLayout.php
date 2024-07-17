<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use RalphJSmit\Livewire\Urls\Facades\Url;

class PublicLayout extends Component
{
//    /**
//     * Current Route
//     */
//    public $currentRoute;

    /**
     * Create a new component instance.
     */
    public function __construct( public bool $green = false ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.public' );
    }
}
