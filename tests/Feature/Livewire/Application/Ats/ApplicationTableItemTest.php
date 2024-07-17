<?php

use App\Livewire\Application\Ats\ApplicationTableItem;
use App\Models\Application;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ApplicationTableItem::class)
        ->assertStatus(200);
});

it('decline dispatches update', function () {
    $testAppliation = new Application();
    Livewire::test(ApplicationTableItem::class, $testAppliation )
        ->call('declineApplicant')->assertDispatched('update_ats_table');
});
