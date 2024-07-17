<?php

namespace Tests\Feature\Livewire\ServiceWizard;

use App\Livewire\ServiceWizard\FirstStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FirstStepTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(FirstStep::class)
            ->assertStatus(200);
    }
}
