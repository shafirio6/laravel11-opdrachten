<?php

use App\Models\Project;

beforeEach(function () {
    $this->project = Project::factory()->create();
    $this->seed('ProjectSeeder');
});

test('admin page is visable on the website', function () {
    $this->withoutExceptionHandling();
    $this->get('/admin')
        ->assertViewIs('layouts.layoutadmin')
        ->assertSee('Laravel Opdrachten')
        ->assertStatus(200);
})->group('Opdracht3');
