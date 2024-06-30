<?php

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ProjectSeeder');
});

// Test that student can access index, create, store, edit, and update methods
test('student can access index, create, store, edit, and update methods', function () {
    $student = User::where('email', 'student@school.nl')->first();
    $this->actingAs($student)
        ->get(route('projects.index'))
        ->assertStatus(200);
    $this->actingAs($student)
        ->get(route('projects.create'))
        ->assertStatus(200);
    $this->actingAs($student)
        ->post(route('projects.store'), [
            'name' => 'New Project',
            'description' => 'Project description',
        ])->assertStatus(302);
    $project = Project::first();
    $this->actingAs($student)
        ->get(route('projects.edit', $project->id))
        ->assertStatus(200);
    $this->actingAs($student)
        ->patch(route('projects.update', $project->id), [
            'name' => 'Updated Project',
            'description' => 'Updated description',
        ])->assertStatus(302);
})->group('Opdracht15');

// Test that student cannot access destroy method
test('student cannot access delete and destroy method', function () {
    $student = User::where('email', 'student@school.nl')->first();
    $project = Project::first();
    // Controleer of de student niet bij het delete bevestigingsformulier kan komen
    $this->actingAs($student)
        ->get(route('projects.delete', $project->id))  // Assuming 'projects.delete' is the named route for the delete confirmation page
        ->assertStatus(403, 'Permission not assigned correctly to the delete method in the ProjectController.');
    // Controleer of de student niet bij de destroy methode kan komen
    $this->actingAs($student)
        ->delete(route('projects.destroy', $project->id))
        ->assertStatus(403, 'Permission not assigned correctly to the destroy method in the ProjectController.');
})->group('Opdracht15');

// Test that teacher can access index, create, store, edit, update, and destroy methods
test('teacher can access all methods', function () {
    $teacher = User::where('email', 'teacher@school.nl')->first();
    $this->actingAs($teacher)
        ->get(route('projects.index'))
        ->assertStatus(200);
    $this->actingAs($teacher)
        ->get(route('projects.create'))
        ->assertStatus(200);
    $this->actingAs($teacher)
        ->post(route('projects.store'), [
            'name' => 'New Project',
            'description' => 'Project description',
        ])->assertStatus(302);
    $project = Project::first();
    $this->actingAs($teacher)
        ->get(route('projects.edit', $project->id))
        ->assertStatus(200);
    $this->actingAs($teacher)
        ->patch(route('projects.update', $project->id), [
            'name' => 'Updated Project',
            'description' => 'Updated description',
        ])->assertStatus(302);
    $this->actingAs($teacher)
        ->get(route('projects.delete', $project->id))
        ->assertStatus(200);
    $this->actingAs($teacher)
        ->delete(route('projects.destroy', $project->id))
        ->assertStatus(302);
})->group('Opdracht15');

// Test that admin can access all methods
test('admin can access all methods', function () {
    $admin = User::where('email', 'admin@school.nl')->first();
    $this->actingAs($admin)
        ->get(route('projects.index'))
        ->assertStatus(200);
    $this->actingAs($admin)
        ->get(route('projects.create'))
        ->assertStatus(200);
    $this->actingAs($admin)
        ->post(route('projects.store'), [
            'name' => 'New Project',
            'description' => 'Project description',
        ])->assertStatus(302);
    $project = Project::first();
    $this->actingAs($admin)
        ->get(route('projects.edit', $project->id))
        ->assertStatus(200);
    $this->actingAs($admin)
        ->patch(route('projects.update', $project->id), [
            'name' => 'Updated Project',
            'description' => 'Updated description',
        ])->assertStatus(302);
    $this->actingAs($admin)
        ->get(route('projects.delete', $project->id))
        ->assertStatus(200);
    $this->actingAs($admin)
        ->delete(route('projects.destroy', $project->id))
        ->assertStatus(302);
})->group('Opdracht15');

// Test that unauthenticated users cannot access any method
test('unauthenticated users cannot access any method', function () {
    Auth::logout(); // Ensure the user is logged out
    $project = Project::first();
    $this->get(route('projects.index'))->assertStatus(403);
    $this->get(route('projects.create'))->assertStatus(403);
    $this->post(route('projects.store'), [
        'name' => 'New Project',
        'description' => 'Project description',
    ])->assertStatus(403);
    $this->get(route('projects.edit', $project->id))->assertStatus(403);
    $this->patch(route('projects.update', $project->id), [
        'name' => 'Updated Project',
        'description' => 'Updated description',
    ])->assertStatus(403);
    $this->get(route('projects.delete', $project->id))->assertStatus(403);
    $this->delete(route('projects.destroy', $project->id))->assertStatus(403);
})->group('Opdracht15');

// Test that project creation link is visible for users with create permission
test('project creation link is visible for users with create permission', function () {
    $admin = User::where('email', 'admin@school.nl')->first();
    $this->actingAs($admin)
        ->get(route('projects.index'))
        ->assertSee('href="' . route('projects.create') . '"', false);

    $teacher = User::where('email', 'teacher@school.nl')->first();
    $this->actingAs($teacher)
        ->get(route('projects.index'))
        ->assertSee('href="' . route('projects.create') . '"', false);

    $student = User::where('email', 'student@school.nl')->first();
    $this->actingAs($student)
        ->get(route('projects.index'))
        ->assertSee('href="' . route('projects.create') . '"', false);
})->group('Opdracht15');

// Test that project edit link is visible for users with edit permission
test('project edit link is visible for users with edit permission', function () {
    $project = Project::first();

    $admin = User::where('email', 'admin@school.nl')->first();
    $this->actingAs($admin)
        ->get(route('projects.index'))
        ->assertSee('href="' . route('projects.edit', $project->id) . '"', false);

    $teacher = User::where('email', 'teacher@school.nl')->first();
    $this->actingAs($teacher)
        ->get(route('projects.index'))
        ->assertSee('href="' . route('projects.edit', $project->id) . '"', false);

    $student = User::where('email', 'student@school.nl')->first();
    $this->actingAs($student)
        ->get(route('projects.index'))
        ->assertSee('href="' . route('projects.edit', $project->id) . '"', false);
})->group('Opdracht15');

// Test that project delete link is visible for users with delete permission
test('project delete link is visible for users with delete permission', function () {
    $project = Project::first();

    $admin = User::where('email', 'admin@school.nl')->first();
    $this->actingAs($admin)
        ->get(route('projects.index'))
        ->assertSee('href="' . route('projects.delete', $project->id) . '"', false);

    $teacher = User::where('email', 'teacher@school.nl')->first();
    $this->actingAs($teacher)
        ->get(route('projects.index'))
        ->assertSee('href="' . route('projects.delete', $project->id) . '"', false);
})->group('Opdracht15');

// Test that project delete link is not visible for users without delete permission
test('project delete link is not visible for users without delete permission', function () {
    $project = Project::first();

    $student = User::where('email', 'student@school.nl')->first();
    $this->actingAs($student)
        ->get(route('projects.index'))
        ->assertDontSee('href="' . route('projects.delete', $project->id) . '"', false);
})->group('Opdracht15');
