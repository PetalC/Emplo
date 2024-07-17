<?php

test('about page loads', function () {
    $response = $this->get('/about');
    $response->assertStatus(200);
});

test( 'about page contains livewire component', function () {
    $response = $this->get('/about');
    $response->assertSeeLivewire('about');
});

