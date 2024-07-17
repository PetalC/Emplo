<?php

namespace Tests\Feature\Livewire\Job;

use App\Livewire\Job\Apply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ApplyTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        $this->get('/job/1/apply')->assertSeeLivewire(Apply::class);
        // Livewire::test(Apply::class)
            // ->assertStatus(200);
    }
}
