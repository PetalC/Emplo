<?php

namespace Tests\Feature\Livewire\ServiceWizard;

use App\Livewire\ServiceWizard\FifthStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FifthStepTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(FifthStep::class)
            ->assertStatus(200);
    }
}
