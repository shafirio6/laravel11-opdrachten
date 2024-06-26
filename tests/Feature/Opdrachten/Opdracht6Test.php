<?php

use App\Models\Project;

beforeEach(function (){
    $this->project = Project::factory()->create();
    $this->seed('ProjectSeeder');
});

test('when posting a project it requires a name', function () {
    $project = Project::factory()->make(['name' => null, 'description' => 'dit is een test project']);

    $this->postJson(route('projects.store'), $project->toArray())
        ->assertStatus(422)
        ->assertSee('The name field is required.');

})->group('Opdracht6');

test('when posting a project the name is minimal 5 characters long', function () {
    $project = Project::factory()->make(['name' => 'test', 'description' => 'dit is een test project']);

    $this->postJson(route('projects.store'), $project->toArray())
        ->assertStatus(422)
        ->assertSee('The name field must be at least 5 characters.');
})->group('Opdracht6');

test('when posting a project the name is maximal 45 characters long', function () {
    $project = Project::factory()->make(['name' => 'TestingIfThisNameCanBeMoreThen45CharactersLong', 'description' => 'dit is een test project']);

    $this->postJson(route('projects.store'), $project->toArray())
        ->assertStatus(422)->assertSee('The name field must not be greater than 45 characters.');
})->group('Opdracht6');

test('when posting a project the name is unique', function () {
    $project1 = Project::factory()->create(['name' => 'testing123']);
    $project2 = Project::factory()->make(['name' => 'testing123', 'description' => 'dit is een test project']);

    $this->postJson(route('projects.store'), $project2->toArray())
        ->assertStatus(422)->assertSee('The name has already been taken.');
})->group('Opdracht6');

test('when posting a project it requires a description', function () {
    $project = Project::factory()->make(['name' => 'testing123', 'description' => null]);

    $this->postJson(route('projects.store'), $project->toArray())
        ->assertStatus(422)->assertSee('The description field is required.');
})->group('Opdracht6');

test('store method uses ProjectStoreRequest', function () {
    $controller = new \App\Http\Controllers\Admin\ProjectController();
    $method = new ReflectionMethod($controller, 'store');
    $parameters = $method->getParameters();

    $this->assertEquals(App\Http\Requests\ProjectStoreRequest::class, $parameters[0]->getType()->getName());
})->group('Opdracht6');

test('store method redirects to index after successful store and shows flash message', function () {
    // Post request naar store route met correcte data
    $response = $this->postJson(route('projects.store'), [
        'name' => 'A valid project name',
        'description' => 'A valid project description',
    ]);
    // Assert of we een redirect status van 302 hebben (redirect)
    $response->assertStatus(302);

    // Assert of de redirect naar project.index gaat
    $response->assertRedirect(route('projects.index'));

    // Assert of het project in de database staat
    $this->assertDatabaseHas('projects', [
        'name' => 'A valid project name',
        'description' => 'A valid project description',
    ]);

    // Assert of de melding met session wordt gebruikt
    $response->assertSessionHas('status', 'Project A valid project name is aangemaakt');

    // volg de redirect en check of de flash message op het scherm staat
    $this->followingRedirects()
        ->get(route('projects.index'))
        ->assertSee('Project A valid project name is aangemaakt');
})->group('Opdracht6');
