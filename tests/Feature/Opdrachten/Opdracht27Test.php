<?php

use App\Models\User;
use App\Models\Task;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ActivitySeeder');
    $this->seed('ProjectSeeder');
    $this->seed('TaskSeeder');
});

// Test of de destroy methode de taak verwijdert uit de database
test('destroy method deletes the task from the database', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $this->delete(route('tasks.destroy', $task->id));

    // Assert dat de taak is verwijderd
    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
})->group('Opdracht27');

// Test of de destroy methode een redirect naar de indexpagina uitvoert
test('destroy method redirects to index page', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $response = $this->delete(route('tasks.destroy', $task->id));

    // Assert dat de redirect naar de index pagina gaat
    $response->assertRedirect(route('tasks.index'));
})->group('Opdracht27');

// Test of de destroy methode een statusbericht in de sessie plaatst
test('destroy method sets a status message in the session', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $response = $this->delete(route('tasks.destroy', $task->id));

    // Assert dat de flash message in de session staat
    $response->assertSessionHas('status', "Taak: $task->task is verwijderd");
})->group('Opdracht27');

// Test of de flash message op de indexpagina wordt weergegeven
test('flash message is displayed on the index page after delete', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();
    $this->delete(route('tasks.destroy', $task->id));

    // Volg de redirect en controleer of de flash message op de pagina staat
    $this->followingRedirects()
        ->get(route('tasks.index'))
        ->assertSee("Taak: $task->task is verwijderd");
})->group('Opdracht27');

