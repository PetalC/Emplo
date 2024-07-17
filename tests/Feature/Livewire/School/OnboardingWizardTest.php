<?php

use App\Livewire\School\OnboardingWizard;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(OnboardingWizard::class)
        ->assertStatus(200);
});
