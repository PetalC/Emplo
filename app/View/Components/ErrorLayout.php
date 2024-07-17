<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use RalphJSmit\Livewire\Urls\Facades\Url;

class ErrorLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.error');
    }
}
