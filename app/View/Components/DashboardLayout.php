<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use RalphJSmit\Livewire\Urls\Facades\Url;

class DashboardLayout extends Component
{
//    /**
//     * Create a new component instance.
//     */
//    public $currentRoute;

    public function __construct() {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.dashboard');
    }
}
