<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\seed;

// Verifieer of de Spatie\Permission\PermissionServiceProvider is geregistreerd in config/app.php
test('Spatie PermissionServiceProvider is registered', function () {
    $configPath = base_path('bootstrap/providers.php');
    $configContent = file_get_contents($configPath);

    $this->assertStringContainsString(
        'Spatie\Permission\PermissionServiceProvider::class',
        $configContent,
        'Spatie\Permission\PermissionServiceProvider is not registered in config/app.php'
    );
})->group('Opdracht12');

test('config/permission.php file exists', function () {
    $this->assertTrue(File::exists(config_path('permission.php')), 'config/permission.php file does not exist');
})->group('Opdracht12');

test('migration file for creating permission tables exists', function () {
    $migrationFiles = File::files(database_path('migrations'));

    $migrationFileExists = false;
    foreach ($migrationFiles as $file) {
        if (str_contains($file->getFilename(), 'create_permission_tables.php')) {
            $migrationFileExists = true;
            break;
        }
    }

    $this->assertTrue($migrationFileExists, 'Migration file for creating permission tables does not exist');
})->group('Opdracht12');

// Test of de HasRoles trait is opgenomen in de User model
test('User model uses HasRoles trait', function () {
    $reflection = new ReflectionClass(\App\Models\User::class);

    $this->assertTrue(
        in_array(\Spatie\Permission\Traits\HasRoles::class, array_keys($reflection->getTraits())),
        'User model does not use the HasRoles trait'
    );
})->group('Opdracht12');

// Test of de juiste use declaratie aanwezig is in de User model
test('User model imports HasRoles trait correctly', function () {
    $userModelPath = app_path('Models/User.php');
    $userModelContent = file_get_contents($userModelPath);

    $this->assertStringContainsString(
        'use Spatie\Permission\Traits\HasRoles;',
        $userModelContent,
        'User model does not import HasRoles trait correctly'
    );
})->group('Opdracht12');

beforeEach(function () {
    seed(RoleAndPermissionSeeder::class);
});

test('student role exists', function () {
    assertDatabaseHas('roles', ['name' => 'student']);
})->group('Opdracht12');

test('teacher role exists', function () {
    assertDatabaseHas('roles', ['name' => 'teacher']);
})->group('Opdracht12');

test('admin role exists', function () {
    assertDatabaseHas('roles', ['name' => 'admin']);
})->group('Opdracht12');

test('project index permission exists', function () {
    assertDatabaseHas('permissions', ['name' => 'index project']);
})->group('Opdracht12');

test('project create permission exists', function () {
    assertDatabaseHas('permissions', ['name' => 'create project']);
})->group('Opdracht12');

test('project show permission exists', function () {
    assertDatabaseHas('permissions', ['name' => 'show project']);
})->group('Opdracht12');

test('project edit permission exists', function () {
    assertDatabaseHas('permissions', ['name' => 'edit project']);
})->group('Opdracht12');

test('project delete permission exists', function () {
    assertDatabaseHas('permissions', ['name' => 'delete project']);
})->group('Opdracht12');

test('student role has correct permissions', function () {
    $studentRole = Role::where('name', 'student')->first();
    $permissions = ['index project', 'create project', 'show project', 'edit project'];

    foreach ($permissions as $permission) {
        expect($studentRole->hasPermissionTo($permission))->toBeTrue();
    }

    expect($studentRole->hasPermissionTo('delete project'))->toBeFalse();
})->group('Opdracht12');

test('teacher role has correct permissions', function () {
    $teacherRole = Role::where('name', 'teacher')->first();
    $permissions = ['index project', 'create project', 'show project', 'edit project', 'delete project'];

    foreach ($permissions as $permission) {
        expect($teacherRole->hasPermissionTo($permission))->toBeTrue();
    }

//    expect($teacherRole->hasPermissionTo('delete project'))->toBeFalse();
})->group('Opdracht12');

test('admin role has all permissions', function () {
    $adminRole = Role::where('name', 'admin')->first();
    $permissions = ['index project', 'create project', 'show project', 'edit project', 'delete project'];

    foreach ($permissions as $permission) {
        expect($adminRole->hasPermissionTo($permission))->toBeTrue();
    }
})->group('Opdracht12');
