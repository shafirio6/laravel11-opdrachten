<?php

use App\Models\Project;

beforeEach(function (){
    $this->project = Project::factory()->create();
    $this->seed('ProjectSeeder');
});

test('An project admin index page is visable with projects on the page', function()
{
    $this->withoutExceptionHandling();
    $this->get(route('projects.index'))
        ->assertViewIs('admin.projects.index')
        ->assertSee($this->project->id)
        ->assertSee($this->project->name)
        ->assertStatus(200);
})->group('Opdracht4');
