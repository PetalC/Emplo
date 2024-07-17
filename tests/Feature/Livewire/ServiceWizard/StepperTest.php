<?php

namespace Tests\Feature\Livewire\ServiceWizard;

use App\Livewire\ServiceWizard\Stepper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class StepperTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Stepper::class)
            ->assertStatus(200);
    }
}
