<?php

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Activity;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ActivitySeeder');
    $this->seed('ProjectSeeder');
    $this->seed('TaskSeeder');
});

// Test of de show pagina toegankelijk is voor gebruikers met de juiste permissies
test('task show page is accessible for users with show task permission', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $this->get(route('tasks.show', $task))
        ->assertStatus(200)
        ->assertViewIs('admin.tasks.show');
})->group('Opdracht23');

// Test of de show pagina de correcte gegevens weergeeft
test('task show page displays correct data', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::with(['user', 'project', 'activity'])->first();
    $response = $this->get(route('tasks.show', $task));

    $response->assertSee((string) $task->id);
    $response->assertSee($task->task);
    $response->assertSee($task->begindate);
    $response->assertSee($task->enddate ?? 'N/A');
    $response->assertSee($task->user->name ?? 'N/A');
    $response->assertSee($task->project->name);
    $response->assertSee($task->activity->name);
    $response->assertSee($task->created_at);
})->group('Opdracht23');
