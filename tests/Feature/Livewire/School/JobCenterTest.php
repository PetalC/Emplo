<?php

namespace Tests\Feature\Livewire\School;

use App\Livewire\School\JobCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class JobCenterTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(JobCenter::class)
            ->assertStatus(200);
    }
}
