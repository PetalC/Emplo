<?php

namespace Tests\Feature\Livewire\School;

use App\Livewire\School\RoleCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RoleCardTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(RoleCard::class)
            ->assertStatus(200);
    }
}
