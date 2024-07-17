<?php

namespace Tests\Feature\Livewire\ServiceWizard;

use App\Livewire\ServiceWizard\ThirdStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ThirdStepTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ThirdStep::class)
            ->assertStatus(200);
    }
}
