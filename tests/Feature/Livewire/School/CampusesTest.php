<?php

use App\Livewire\School\Campuses;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Campuses::class)
        ->assertStatus(200);
});
