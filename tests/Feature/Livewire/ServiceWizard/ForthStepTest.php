<?php

namespace Tests\Feature\Livewire\ServiceWizard;

use App\Livewire\ServiceWizard\ForthStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ForthStepTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ForthStep::class)
            ->assertStatus(200);
    }
}
