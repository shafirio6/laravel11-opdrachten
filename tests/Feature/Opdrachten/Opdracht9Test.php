<?php

use App\Models\Project;

beforeEach(function (){
    $this->project = Project::factory()->create();
    $this->seed('ProjectSeeder');
});

test('delete project page is visable', function()
{
    $this->withoutExceptionHandling();
    $this->get(route('projects.delete',['project' => $this->project->id]))
        ->assertViewIs('admin.projects.delete')
        ->assertSee($this->project->name)
        ->assertSee($this->project->description)
        ->assertStatus(200);
})->group('Opdracht9');

test('In de delete form is the correct action', function()
{
    $this->withoutExceptionHandling();
    $expectedAction = route('projects.destroy',['project' => $this->project->id]);

    $response = $this->get(route('projects.delete',['project' => $this->project->id]));
    $response->assertViewIs('admin.projects.delete');

    // Zorg ervoor dat de action URL correct is in het formulier
    $response->assertSee('action="' . $expectedAction . '"', false);

    $response->assertStatus(200);
})->group('Opdracht9');

test('a project can be deleted', function(){
    $this->json('DELETE', route('projects.destroy', ['project' => $this->project->id]))
        ->assertRedirect(route('projects.index'));
    $this->assertDatabaseMissing('projects', ['id' => $this->project->id]);
})->group('Opdracht9');


test('delete method redirects to index after successful store and shows flash message', function () {
    // Post request naar store route met correcte data
    $project = Project::factory()->create(['name' => 'testproject', 'description' => 'dit is een test project']);
    $response = $this->json('DELETE', route('projects.destroy', ['project' => $project->id]))
        ->assertRedirect(route('projects.index'));

    // Assert of we een redirect status van 302 hebben (redirect)
    $response->assertStatus(302);

    // Assert of de melding met session wordt gebruikt
    $response->assertSessionHas('status', 'Project testproject is verwijderd');

    // volg de redirect en check of de flash message op het scherm staat
    $this->followingRedirects()
        ->get(route('projects.index'))
        ->assertSee('Project testproject is verwijderd');
})->group('Opdracht9');

