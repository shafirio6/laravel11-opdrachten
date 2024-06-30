<?php

use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Task;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ActivitySeeder');
    $this->seed('ProjectSeeder');
    $this->seed('TaskSeeder');
});

// Test of de delete pagina toegankelijk is voor gebruikers met de juiste permissies
test('task delete page is accessible for users with delete task permission', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);
    $task = Task::first();

    $response = $this->get(route('tasks.delete', $task->id));
    $response->assertStatus(200);
    $response->assertViewIs('admin.tasks.delete');
})->group('Opdracht26');

// Test of de delete pagina de correcte inputvelden bevat
test('task delete page contains the correct input fields', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);
    $task = Task::with('user', 'project', 'activity')->first();

    $response = $this->get(route('tasks.delete', $task->id));

    $response->assertSee('name="task"', false);
    $response->assertSee('name="begindate"', false);
    $response->assertSee('name="enddate"', false);
    $response->assertSee('name="user_id"', false);
    $response->assertSee('name="project_id"', false);
    $response->assertSee('name="activity_id"', false);
})->group('Opdracht26');

// Test of de inputvelden disabled zijn
test('task delete page input fields are disabled', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);
    $task = Task::with('user', 'project', 'activity')->first();

    $response = $this->get(route('tasks.delete', $task->id));

    $response->assertSee('name="task" value="'.$task->task.'" disabled', false);
    $response->assertSee('name="begindate" value="'.$task->begindate.'" disabled', false);
    $response->assertSee('name="enddate" value="'.$task->enddate.'" disabled', false);
    $response->assertSee('name="user_id" disabled', false);
    $response->assertSee('name="project_id" disabled', false);
    $response->assertSee('name="activity_id" disabled', false);
})->group('Opdracht26');

// Test of de dropdown opties correct zijn voor user, project en activity
test('task delete page contains correct dropdown options', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);
    $task = Task::with('user', 'project', 'activity')->first();

    $response = $this->get(route('tasks.delete', $task->id));

    if ($task->user) {
        $response->assertSee('<option value="'.$task->user->id.'">'.$task->user->name.'</option>', false);
    }
    $response->assertSee('<option value="'.$task->project->id.'">'.$task->project->name.'</option>', false);
    $response->assertSee('<option value="'.$task->activity->id.'">'.$task->activity->name.'</option>', false);
})->group('Opdracht26');

// Test of de juiste action in het formulier zit
test('task delete page contains correct form action', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);
    $task = Task::with('user', 'project', 'activity')->first();

    $response = $this->get(route('tasks.delete', $task->id));
    $response->assertSee('action="'.route('tasks.destroy', $task->id).'"', false);
})->group('Opdracht26');
