<?php

namespace Tests\Feature\Livewire\School;

use App\Livewire\School\JobOperationMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class JobOperationMenuTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(JobOperationMenu::class)
            ->assertStatus(200);
    }
}
