<?php

use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ActivitySeeder');
    $this->seed('ProjectSeeder');
});

// Test of de gegevens correct in de database worden opgeslagen
test('task is stored correctly in the database when using correct data and showing flash message', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => 'Nieuwe Taak Beschrijving',
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => $user->id,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->post(route('tasks.store'), $taskData);

    // Assert of we een redirect status van 302 hebben (redirect)
    $response->assertStatus(302);
    // Controleer of de gebruiker wordt doorgestuurd naar de index route
    $response->assertRedirect(route('tasks.index'));

    // Controleer of de gegevens correct in de database zijn opgeslagen
    $this->assertDatabaseHas('tasks', [
        'task' => $taskData['task'],
        'begindate' => $taskData['begindate'],
        'enddate' => $taskData['enddate'],
        'user_id' => $taskData['user_id'],
        'project_id' => $taskData['project_id'],
        'activity_id' => $taskData['activity_id'],
    ]);

    // Assert of de melding met session wordt gebruikt
    $response->assertSessionHas('status', 'Taak: Nieuwe Taak Beschrijving is aangemaakt');

    // Volg de redirect en check of de flash message op het scherm staat
    $this->followingRedirects()
        ->get(route('tasks.index'))
        ->assertSee('Taak: Nieuwe Taak Beschrijving is aangemaakt');
})->group('Opdracht22');

// Test voor taakbeschrijving minimale lengte
test('task description must be at least 10 characters', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => 'Short',
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => $user->id,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);
    $response->assertStatus(422)->assertSee('The task field must be at least 10 characters.');
})->group('Opdracht22');

// Test voor taakbeschrijving maximale lengte
test('task description must not exceed 200 characters', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => str_repeat('a', 201),
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => $user->id,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);
    $response->assertStatus(422)->assertSee('The task field must not be greater than 200 characters.');

})->group('Opdracht22');

// Test voor geldige begindatum
test('begindate must be a valid date', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => 'not-a-date',
        'enddate' => '2024-01-10',
        'user_id' => $user->id,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);
    $response->assertStatus(422)->assertSee('The begindate field must be a valid date.');
})->group('Opdracht22');

// Test voor optionele einddatum
test('enddate must be a valid date or null', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => '2024-01-01',
        'enddate' => 'not-a-date',
        'user_id' => $user->id,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);
    $response->assertStatus(422)->assertSee('The enddate field must be a valid date.');

    // Test met null waarde
    $taskDataNull = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => '2024-01-01',
        'enddate' => null,
        'user_id' => $user->id,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->post(route('tasks.store'), $taskDataNull);
    $response->assertStatus(302);
    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'task' => 'Een valide taak beschrijving',
        'enddate' => null,
    ]);
})->group('Opdracht22');

// Test voor optionele user_id
test('user_id can be null or a valid user id', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => null,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->post(route('tasks.store'), $taskData);
    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'task' => 'Een valide taak beschrijving',
        'user_id' => null
    ]);
})->group('Opdracht22');

// Test voor ongeldige user_id
test('user_id must be a valid user id', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => 9999, // Non-existent user ID
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);
    $response->assertStatus(422)->assertSee('The selected user id is invalid.');
})->group('Opdracht22');

// Test voor geldige project_id
test('project_id must be a valid project id', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => $user->id,
        'project_id' => 9999, // Non-existent project ID
        'activity_id' => Activity::first()->id,
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);
    $response->assertStatus(422)->assertSee('The selected project id is invalid.');
})->group('Opdracht22');

// Test voor geldige activity_id
test('activity_id must be a valid activity id', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => $user->id,
        'project_id' => Project::first()->id,
        'activity_id' => 9999, // Non-existent activity ID
    ];

    $response = $this->postJson(route('tasks.store'), $taskData);
    $response->assertStatus(422)->assertSee('The selected activity id is invalid.');
})->group('Opdracht22');

// Test of de TaskStoreRequest wordt gebruikt in de store methode
test('store method uses TaskStoreRequest', function () {
    $controller = new \App\Http\Controllers\Admin\TaskController();
    $method = new ReflectionMethod($controller, 'store');
    $parameters = $method->getParameters();

    $this->assertEquals(App\Http\Requests\TaskStoreRequest::class, $parameters[0]->getType()->getName());
})->group('Opdracht22');

// Test dat mass assignment niet mogelijk is
test('Mass assignment is not possible', function () {
    $data = [
        'task' => 'testtask',
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => User::first()->id,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
        'non_existent_field' => 'should_not_be_filled' // Dit veld zou beschermd moeten zijn tegen mass assignment
    ];

    // Maak een nieuwe instantie van Task zonder het op te slaan
    $task = new Task($data);

    // Controleer dat geen van de velden zijn ingesteld
    $this->assertNull($task->task);
    $this->assertNull($task->begindate);
    $this->assertNull($task->enddate);
    $this->assertNull($task->user_id);
    $this->assertNull($task->project_id);
    $this->assertNull($task->activity_id);
    $this->assertNull($task->non_existent_field);

    // Controleer dat er geen gegevens in de database zijn opgeslagen
    $this->assertDatabaseMissing('tasks', [
        'task' => 'testtask',
        'begindate' => '2024-01-01',
        'enddate' => '2024-01-10',
        'user_id' => User::first()->id,
        'project_id' => Project::first()->id,
        'activity_id' => Activity::first()->id,
    ]);
})->group('Opdracht22');



// Test dat het Task model de juiste guarded eigenschappen heeft ingesteld
test('The Task model should have correctly set guarded attributes', function () {
    $task = new Task();

    // Lijst van velden die verwacht worden als guarded
    $expectedGuarded = [
        'task',
        'begindate',
        'enddate',
        'user_id',
        'project_id',
        'activity_id'
    ];

    // Assert dat de werkelijke guarded velden in het model overeenkomen met de verwachte guarded velden
    $this->assertEquals($expectedGuarded, $task->getGuarded());
})->group('Opdracht22');


