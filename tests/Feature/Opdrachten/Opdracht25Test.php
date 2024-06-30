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
    $this->seed('TaskSeeder');
});

// Test of de gegevens correct in de database worden bijgewerkt
test('task is updated correctly in the database when using correct data and showing flash message', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $updatedTaskData = [
        'task' => 'Bijgewerkte Taak Beschrijving',
        'begindate' => '2024-02-01',
        'enddate' => '2024-02-10',
        'user_id' => $task->user_id,
        'project_id' => $task->project_id,
        'activity_id' => $task->activity_id,
    ];

    $response = $this->put(route('tasks.update', $task->id), $updatedTaskData);

    // Assert of we een redirect status van 302 hebben (redirect)
    $response->assertStatus(302);
    // Controleer of de gebruiker wordt doorgestuurd naar de index route
    $response->assertRedirect(route('tasks.index'));

    // Controleer of de gegevens correct in de database zijn bijgewerkt
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'task' => $updatedTaskData['task'],
        'begindate' => $updatedTaskData['begindate'],
        'enddate' => $updatedTaskData['enddate'],
        'user_id' => $updatedTaskData['user_id'],
        'project_id' => $updatedTaskData['project_id'],
        'activity_id' => $updatedTaskData['activity_id'],
    ]);

    // Assert of de melding met session wordt gebruikt
    $response->assertSessionHas('status', 'Taak: Bijgewerkte Taak Beschrijving is bijgewerkt');

    // Volg de redirect en check of de flash message op het scherm staat
    $this->followingRedirects()
        ->get(route('tasks.index'))
        ->assertSee('Taak: Bijgewerkte Taak Beschrijving is bijgewerkt');
})->group('Opdracht25');

// Test voor taakbeschrijving minimale lengte
test('task description must be at least 10 characters', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $taskData = [
        'task' => 'Short',
        'begindate' => $task->begindate,
        'enddate' => $task->enddate,
        'user_id' => $task->user_id,
        'project_id' => $task->project_id,
        'activity_id' => $task->activity_id,
    ];

    $response = $this->putJson(route('tasks.update', $task->id), $taskData);
    $response->assertStatus(422)->assertSee('The task field must be at least 10 characters.');
})->group('Opdracht25');

// Test voor taakbeschrijving maximale lengte
test('task description must not exceed 200 characters', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $taskData = [
        'task' => str_repeat('a', 201),
        'begindate' => $task->begindate,
        'enddate' => $task->enddate,
        'user_id' => $task->user_id,
        'project_id' => $task->project_id,
        'activity_id' => $task->activity_id,
    ];

    $response = $this->putJson(route('tasks.update', $task->id), $taskData);
    $response->assertStatus(422)->assertSee('The task field must not be greater than 200 characters.');
})->group('Opdracht25');

// Test voor geldige begindatum
test('begindate must be a valid date', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => 'not-a-date',
        'enddate' => $task->enddate,
        'user_id' => $task->user_id,
        'project_id' => $task->project_id,
        'activity_id' => $task->activity_id,
    ];

    $response = $this->putJson(route('tasks.update', $task->id), $taskData);
    $response->assertStatus(422)->assertSee('The begindate field must be a valid date.');
})->group('Opdracht25');

// Test voor optionele einddatum
test('enddate must be a valid date or null', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => $task->begindate,
        'enddate' => 'not-a-date',
        'user_id' => $task->user_id,
        'project_id' => $task->project_id,
        'activity_id' => $task->activity_id,
    ];

    $response = $this->putJson(route('tasks.update', $task->id), $taskData);
    $response->assertStatus(422)->assertSee('The enddate field must be a valid date.');

    // Test met null waarde
    $taskDataNull = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => $task->begindate,
        'enddate' => null,
        'user_id' => $task->user_id,
        'project_id' => $task->project_id,
        'activity_id' => $task->activity_id,
    ];

    $response = $this->put(route('tasks.update', $task->id), $taskDataNull);
    $response->assertStatus(302);
    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'task' => 'Een valide taak beschrijving',
        'enddate' => null,
    ]);
})->group('Opdracht25');

// Test voor optionele user_id
test('user_id can be null or a valid user id', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => $task->begindate,
        'enddate' => $task->enddate,
        'user_id' => null,
        'project_id' => $task->project_id,
        'activity_id' => $task->activity_id,
    ];

    $response = $this->put(route('tasks.update', $task->id), $taskData);
    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'task' => 'Een valide taak beschrijving',
        'user_id' => null
    ]);
})->group('Opdracht25');

// Test voor ongeldige user_id
test('user_id must be a valid user id', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => $task->begindate,
        'enddate' => $task->enddate,
        'user_id' => 9999, // Non-existent user ID
        'project_id' => $task->project_id,
        'activity_id' => $task->activity_id,
    ];

    $response = $this->putJson(route('tasks.update', $task->id), $taskData);
    $response->assertStatus(422)->assertSee('The selected user id is invalid.');
})->group('Opdracht25');

// Test voor geldige project_id
test('project_id must be a valid project id', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => $task->begindate,
        'enddate' => $task->enddate,
        'user_id' => $task->user_id,
        'project_id' => 9999, // Non-existent project ID
        'activity_id' => $task->activity_id,
    ];

    $response = $this->putJson(route('tasks.update', $task->id), $taskData);
    $response->assertStatus(422)->assertSee('The selected project id is invalid.');
})->group('Opdracht25');

// Test voor geldige activity_id
test('activity_id must be a valid activity id', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $taskData = [
        'task' => 'Een valide taak beschrijving',
        'begindate' => $task->begindate,
        'enddate' => $task->enddate,
        'user_id' => $task->user_id,
        'project_id' => $task->project_id,
        'activity_id' => 9999, // Non-existent activity ID
    ];

    $response = $this->putJson(route('tasks.update', $task->id), $taskData);
    $response->assertStatus(422)->assertSee('The selected activity id is invalid.');
})->group('Opdracht25');

// Test of de TaskStoreRequest wordt gebruikt in de update methode
test('update method uses TaskStoreRequest', function () {
    $controller = new \App\Http\Controllers\Admin\TaskController();
    $method = new ReflectionMethod($controller, 'update');
    $parameters = $method->getParameters();

    $this->assertEquals(App\Http\Requests\TaskStoreRequest::class, $parameters[0]->getType()->getName());
})->group('Opdracht25');

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
})->group('Opdracht25');


