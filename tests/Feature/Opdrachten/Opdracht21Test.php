<?php

use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ActivitySeeder');
    $this->seed('ProjectSeeder');
});

// Test of de create pagina toegankelijk is voor gebruikers met de juiste permissies
test('task create page is accessible for users with create task permission', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user)
        ->get(route('tasks.create'))
        ->assertStatus(200)
        ->assertViewIs('admin.tasks.create');
})->group('Opdracht21');

// Test of de create pagina de correcte inputvelden bevat
test('task create page contains the correct input fields', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user)
        ->get(route('tasks.create'))
        ->assertStatus(200)
        ->assertViewIs('admin.tasks.create')
        ->assertSee('name="task"', false)
        ->assertSee('name="begindate"', false)
        ->assertSee('name="enddate"', false)
        ->assertSee('name="user_id"', false)
        ->assertSee('name="project_id"', false)
        ->assertSee('name="activity_id"', false)
        ->assertSee('action="' . route('tasks.store') . '"', false);;
})->group('Opdracht21');

// Test if the tasks create page displays the correct dropdown options for users
test('tasks create page displays correct user dropdown options', function () {
    $user = User::first();
    $this->actingAs($user);
    $users = User::all();
    $response = $this->get(route('tasks.create'));

    foreach ($users as $user) {
        $response->assertSee('<option value="'.$user->id.'">'.$user->name.'</option>', false);
        $response->assertSee($user->name, false);
    }
})->group('Opdracht21');

// Test if the tasks create page displays the correct dropdown options for projects
test('tasks create page displays correct project dropdown options', function () {
    $user = User::first();
    $this->actingAs($user);
    $projects = Project::all();
    $response = $this->get(route('tasks.create'));

    foreach ($projects as $project) {
        $response->assertSee('<option value="'.$project->id.'">'.$project->name.'</option>', false);
        $response->assertSee($project->name, false);
    }
})->group('Opdracht21');

// Test if the tasks create page displays the correct dropdown options for activities
test('tasks create page displays correct activity dropdown options', function () {
    $user = User::first();
    $this->actingAs($user);
    $activities = Activity::all();
    $response = $this->get(route('tasks.create'));

    foreach ($activities as $activity) {
        $response->assertSee('<option value="'.$activity->id.'">'.$activity->name.'</option>', false);
        $response->assertSee($activity->name, false);
    }
})->group('Opdracht21');
