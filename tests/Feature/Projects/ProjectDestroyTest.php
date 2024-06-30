<?php

use App\Models\User;
use App\Models\Project;
use \Pest\Laravel;

beforeEach(function (){
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->project = Project::factory()->create();
});

test('admin can destroy a project', function(){
    $admin = User::find(3);
    Laravel\be($admin);
    $this->json('DELETE', route('projects.destroy', ['project' => $this->project->id]))
        ->assertRedirect(route('projects.index'));
    $this->assertDatabaseMissing('projects', ['id' => $this->project->id]);
})->group('ProjectDestroy', 'Opdracht13oud', 'Website');

test('teacher can destroy a project', function(){
    $teacher = User::find(2);
    Laravel\be($teacher);
    $this->json('DELETE', route('projects.destroy', ['project' => $this->project->id]))
        ->assertRedirect(route('projects.index'));
    $this->assertDatabaseMissing('projects', ['id' => $this->project->id]);
})->group('ProjectDestroy', 'Opdracht13oud', 'Website');

test('student can not destroy a project', function () {
    $student = User::find(1);
    Laravel\be($student);
    $this->json('DELETE', route('projects.destroy', ['project' => $this->project->id]))
        ->assertForbidden();
})->group('ProjectDestroy', 'Opdracht13oud', 'Website');

test('guestcan not destroy a project', function () {
    $this->json('DELETE', route('projects.destroy', ['project' => $this->project->id]))
        ->assertStatus(401);
})->group('ProjectDestroy', 'Opdracht13oud', 'Website');
