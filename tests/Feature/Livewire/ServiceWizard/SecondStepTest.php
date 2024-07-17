<?php

namespace Tests\Feature\Livewire\ServiceWizard;

use App\Livewire\ServiceWizard\SecondStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SecondStepTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(SecondStep::class)
            ->assertStatus(200);
    }
}
