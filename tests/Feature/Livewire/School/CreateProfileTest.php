<?php

namespace Tests\Feature\Livewire\School;

use App\Livewire\School\EditProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateProfileTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EditProfile::class)
            ->assertStatus(200);
    }
}
