<?php

use App\Models\Project;

beforeEach(function (){
    $this->project = Project::factory()->create();
    $this->seed('ProjectSeeder');
});

test('edit project page is visable', function()
{
    $this->withoutExceptionHandling();
    $this->get(route('projects.edit',['project' => $this->project->id]))
        ->assertViewIs('admin.projects.edit')
        ->assertSee($this->project->name)
        ->assertSee($this->project->description)
        ->assertStatus(200);
})->group('Opdracht8');

test('In de edit form are the name input & description textarea', function()
{
    $this->withoutExceptionHandling();
    $this->get(route('projects.edit',['project' => $this->project->id]))
        ->assertViewIs('admin.projects.edit')
        ->assertSee('name="name"', false)  // Gebruik regex om zowel " als ' te matchen
        ->assertSee('name="description"', false)
        ->assertStatus(200);
})->group('Opdracht8');

test('In de edit form is the correct action', function()
{
    $this->withoutExceptionHandling();
    $expectedAction = route('projects.update',['project' => $this->project->id]);

    $response = $this->get(route('projects.edit',['project' => $this->project->id]));
    $response->assertViewIs('admin.projects.edit');

    // Zorg ervoor dat de action URL correct is in het formulier
    $response->assertSee('action="' . $expectedAction . '"', false);

    $response->assertStatus(200);
})->group('Opdracht8');

test('a project can be updated in the database', function () {
    $project = Project::factory()->make(['name' => 'testproject', 'description' => 'dit is een test project']);

    $this->patchJson(route('projects.update',['project' => $this->project->id]), $project->toArray())
        ->assertRedirect(route('projects.index'));

    $this->assertDatabaseHas('projects',[
        'id' => $this->project->id,
        'name' => 'testproject',
        'description' => 'dit is een test project'
    ]);
})->group('Opdracht8');

test('a project cant be updated with empty name in the database', function () {
    $project = Project::factory()->make(['name' => null, 'description' => 'dit is een test project']);

    $this->patchJson(route('projects.update',['project' => $this->project->id]), $project->toArray())
        ->assertStatus(422);
})->group('Opdracht8');

test('a project cant be updated with empty description in the database', function () {
    $project = Project::factory()->make(['name' => 'testproject', 'description' => null]);

    $this->patchJson(route('projects.update',['project' => $this->project->id]), $project->toArray())
        ->assertStatus(422);
})->group('Opdracht8');

test('A project cant be updated when the name is less then 5 characters long', function () {
    $project = Project::factory()->make(['name' => 'test', 'description' => 'dit is een test project']);

    $this->patchJson(route('projects.update',['project' => $this->project->id]), $project->toArray())
        ->assertStatus(422);
})->group('Opdracht8');

test('A project cant be updated when the name is more then 45 characters long', function () {
    $project = Project::factory()->make(['name' => 'TestingIfThisNameCanBeMoreThen45CharactersLong', 'description' => 'dit is een test project']);

    $this->patchJson(route('projects.update',['project' => $this->project->id]), $project->toArray())
        ->assertStatus(422);
})->group('Opdracht8');

test('when updating a project the name is unique', function () {
    $project1 = Project::factory()->create(['name' => 'testing123']);
    $project2 = Project::factory()->make(['name' => 'testing123', 'description' => 'dit is een test project']);

    $this->patchJson(route('projects.update',['project' => $this->project->id]), $project2->toArray())
        ->assertStatus(422);
})->group('Opdracht8');

test('update method uses ProjectUpdateRequest', function () {
    $controller = new \App\Http\Controllers\Admin\ProjectController();
    $method = new ReflectionMethod($controller, 'update');
    $parameters = $method->getParameters();

    $this->assertEquals(App\Http\Requests\ProjectUpdateRequest::class, $parameters[0]->getType()->getName());
})->group('Opdracht8');


test('update method redirects to index after successful store and shows flash message', function () {
    // Post request naar store route met correcte data
    $project = Project::factory()->make(['name' => 'testproject', 'description' => 'dit is een test project']);
    $response = $this->patchJson(route('projects.update',['project' => $this->project->id]), $project->toArray())
        ->assertRedirect(route('projects.index'));

    // Assert of we een redirect status van 302 hebben (redirect)
    $response->assertStatus(302);

    // Assert of de redirect naar project.index gaat
    $response->assertRedirect(route('projects.index'));

    // Assert of het project in de database staat
    $this->assertDatabaseHas('projects', [
        'name' => 'testproject',
        'description' => 'dit is een test project',
    ]);

    // Assert of de melding met session wordt gebruikt
    $response->assertSessionHas('status', 'Project testproject is gewijzigd');

    // volg de redirect en check of de flash message op het scherm staat
    $this->followingRedirects()
        ->get(route('projects.index'))
        ->assertSee('Project testproject is gewijzigd');
})->group('Opdracht8');
