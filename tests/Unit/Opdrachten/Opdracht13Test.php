<?php
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use function Pest\Laravel\seed;

// Test of de UserSeeder bestaat
test('UserSeeder exists', function () {
    $this->assertTrue(File::exists(database_path('seeders/UserSeeder.php')), 'config/permission.php file does not exist');
})->group('Opdracht13');

// Voor we beginnen, run de UserSeeder
beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
});

// Test of de correcte gebruikers zijn aangemaakt
test('correct users are created', function () {
    $this->assertDatabaseHas('users', [
        'id' => 1,
        'name' => 'student',
        'email' => 'student@school.nl',
    ]);

    $this->assertDatabaseHas('users', [
        'id' => 2,
        'name' => 'teacher',
        'email' => 'teacher@school.nl',
    ]);

    $this->assertDatabaseHas('users', [
        'id' => 3,
        'name' => 'admin',
        'email' => 'admin@school.nl',
    ]);
})->group('Opdracht13');

//// Test of de correcte rollen zijn toegewezen aan de gebruikers
test('users have correct roles', function () {
    $student = User::find(1);
    $teacher = User::find(2);
    $admin = User::find(3);

    $this->assertTrue($student->hasRole('student'), 'User with id 1 does not have role student');
    $this->assertTrue($teacher->hasRole('teacher'), 'User with id 2 does not have role teacher');
    $this->assertTrue($admin->hasRole('admin'), 'User with id 3 does not have role admin');
})->group('Opdracht13');
