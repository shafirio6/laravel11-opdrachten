<?php

use App\Models\Project;

beforeEach(function (){
    $this->project = Project::factory()->create();
    $this->seed('ProjectSeeder');
});

test('create project page is visable', function()
{
    $this->withoutExceptionHandling();
    $this->get(route('projects.create'))
        ->assertViewIs('admin.projects.create')
        ->assertStatus(200);
})->group('Opdracht5');

test('In de create form are the name input & description textarea', function()
{
    $this->withoutExceptionHandling();
    $this->get(route('projects.create'))
        ->assertViewIs('admin.projects.create')
        ->assertSee('name="name"', false)  // Gebruik regex om zowel " als ' te matchen
        ->assertSee('name="description"', false)
        ->assertStatus(200);
})->group('Opdracht5');

test('In de create form is the correct action', function()
{
    $this->withoutExceptionHandling();
    $expectedAction = route('projects.store');

    $response = $this->get(route('projects.create'));
    $response->assertViewIs('admin.projects.create');

    // Zorg ervoor dat de action URL correct is in het formulier
    $response->assertSee('action="' . $expectedAction . '"', false);

    $response->assertStatus(200);
})->group('Opdracht5');

test('A project can be stored in the database succesfully', function () {
    $data = [
        'name' => 'testproject',
        'description' => 'dit is een test project'
    ];

    $this->postJson(route('projects.store'), $data)
        ->assertRedirect(route('projects.index'));

    $this->assertDatabaseHas('projects', $data);
})->group('Opdracht5');

test('When saving a project, you will be redirected to the project index route', function () {
    $data = [
        'name' => 'testproject',
        'description' => 'dit is een test project'
    ];

    $this->postJson(route('projects.store'), $data)
        ->assertRedirect(route('projects.index'));
})->group('Opdracht5');


test('Mass assignment is not possible', function () {
    $data = [
        'name' => 'testproject',
        'description' => 'dit is een test project',
        'is_admin' => true // Dit veld zou beschermd moeten zijn tegen mass assignment
    ];

    $this->postJson(route('projects.store'), $data);

    $this->assertDatabaseHas('projects', [
        'name' => 'testproject',
        'description' => 'dit is een test project'
    ]);

    $this->assertDatabaseMissing('projects', [
        'is_admin' => true // Verifieer dat dit veld niet is opgeslagen
    ]);
})->group('Opdracht5');

test('The Project model should have correctly set fillable attributes', function () {
    $project = new Project();

    // List of fields expected to be fillable
    $expectedFillable = ['name', 'description'];

    // Assert that the actual fillable fields in the model match the expected fillable fields
    $this->assertEquals($expectedFillable, $project->getFillable());
})->group('Opdracht5');
