<?php

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ActivitySeeder');
    $this->seed('ProjectSeeder');
    $this->seed('TaskSeeder');
});

test('permissions are assigned correctly', function () {
    $roles = ['student', 'teacher', 'admin'];
    $permissions = ['index task', 'create task', 'show task', 'edit task', 'delete task'];

    foreach ($roles as $roleName) {
        $role = Role::findByName($roleName);
        foreach ($permissions as $permission) {
            $this->assertTrue($role->hasPermissionTo($permission));
        }
    }
})->group('Opdracht20');

// Tests voor toegang door studenten
test('students can access task routes', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();

    $this->get(route('tasks.index'))->assertStatus(200);
    $this->get(route('tasks.create'))->assertStatus(200);
    $this->post(route('tasks.store'))->assertStatus(200); // Assuming empty store method
    $this->get(route('tasks.show', $task->id))->assertStatus(200);
    $this->get(route('tasks.edit', $task->id))->assertStatus(200);
    $this->put(route('tasks.update', $task->id))->assertStatus(200); // Assuming empty update method
    $this->delete(route('tasks.destroy', $task->id))->assertStatus(200); // Assuming empty destroy method
    $this->get(route('tasks.delete', $task->id))->assertStatus(200);
})->group('Opdracht20');

// Tests voor toegang door leraren
test('teachers can access task routes', function () {
    $user = User::where('email', 'teacher@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();

    $this->get(route('tasks.index'))->assertStatus(200);
    $this->get(route('tasks.create'))->assertStatus(200);
    $this->post(route('tasks.store'))->assertStatus(200); // Assuming empty store method
    $this->get(route('tasks.show', $task->id))->assertStatus(200);
    $this->get(route('tasks.edit', $task->id))->assertStatus(200);
    $this->put(route('tasks.update', $task->id))->assertStatus(200); // Assuming empty update method
    $this->delete(route('tasks.destroy', $task->id))->assertStatus(200); // Assuming empty destroy method
    $this->get(route('tasks.delete', $task->id))->assertStatus(200);
})->group('Opdracht20');

// Tests voor toegang door admins
test('admins can access task routes', function () {
    $user = User::where('email', 'admin@school.nl')->first();
    $this->actingAs($user);

    $task = Task::first();

    $this->get(route('tasks.index'))->assertStatus(200);
    $this->get(route('tasks.create'))->assertStatus(200);
    $this->post(route('tasks.store'))->assertStatus(200); // Assuming empty store method
    $this->get(route('tasks.show', $task->id))->assertStatus(200);
    $this->get(route('tasks.edit', $task->id))->assertStatus(200);
    $this->put(route('tasks.update', $task->id))->assertStatus(200); // Assuming empty update method
    $this->delete(route('tasks.destroy', $task->id))->assertStatus(200); // Assuming empty destroy method
    $this->get(route('tasks.delete', $task->id))->assertStatus(200);
})->group('Opdracht20');

// Tests voor niet-geauthenticeerde gebruikers
test('unauthenticated users cannot access any task routes', function () {
    Auth::logout();
    $task = Task::first();

    $this->get(route('tasks.index'))->assertStatus(403);
    $this->get(route('tasks.create'))->assertStatus(403);
    $this->post(route('tasks.store'))->assertStatus(403);
    $this->get(route('tasks.show', $task->id))->assertStatus(403);
    $this->get(route('tasks.edit', $task->id))->assertStatus(403);
    $this->put(route('tasks.update', $task->id))->assertStatus(403);
    $this->delete(route('tasks.destroy', $task->id))->assertStatus(403);
    $this->get(route('tasks.delete', $task->id))->assertStatus(403);
})->group('Opdracht20');


