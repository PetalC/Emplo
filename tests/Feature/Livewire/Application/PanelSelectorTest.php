<?php

namespace Tests\Feature\Livewire\Application;

use App\Livewire\Application\PanelSelector;
use App\Models\Campus;
use App\Models\Job;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PanelSelectorTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_panel_member()
    {

        School::factory()
            ->has(Campus::factory())
            ->create();
        Job::factory()->count(3)
            ->set('school_id', School::all()->first()->id)
            ->set('campus_id', Campus::all()->first()->id)
            ->set('description', 'unit-test')
            ->set('responsibilities', 'unit-test')
            ->set('required_licences_certs', 'unit-test')
            ->create();

        User::factory()->count(2)->create();
        User::factory()->count(1)->create([
            'email' => 'myuser',
            'first_name' => 'Test',
            'last_name' => 'User'
        ]);

        $job = Job::all()->first();

        $this->assertEmpty($job->panel_members);

        Livewire::test(PanelSelector::class, ['job' => $job])
            ->call('addPanelMember', User::all()->first()->id);

        // Reload from DB
        $newJob = Job::find($job->id);
        $this->assertNotEmpty($newJob->panel_members, 'Adding panel member failed');

    }

}
