<?php

use App\Livewire\School\SelectSchool;
use App\Models\User;
use Livewire\Livewire;

it( 'fails to render if unauthenticated', function(){

    Livewire::test(SelectSchool::class)
        ->assertStatus(403 );

    $users = [
        'job_seeker' => User::query()->role( 'Job Seeker' )->first(),
        'school_admin' => User::query()->role( 'School Admin' )->first(),
        'developer' => User::query()->role( 'Developer' )->first(),
    ];

    $results = [
        'job_seeker' => 403,
        'school_admin' => 200,
        'developer' => 403,
    ];

    foreach( $results as $result => $expected ){

        Livewire::actingAs( $users[$result] )
            ->test(SelectSchool::class)
            ->assertStatus($expected);

    }

} );

it( 'selects a school', function(){

} );


