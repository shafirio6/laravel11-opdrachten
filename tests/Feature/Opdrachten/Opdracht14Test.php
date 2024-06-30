<?php

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use \Pest\Laravel;
use Illuminate\Support\Facades\Auth;

beforeEach(function (){
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ProjectSeeder');
});

test('RoleMiddleware is registered in bootstrap/app.php', function () {
    $configPath = base_path('bootstrap/app.php');
    $configContent = file_get_contents($configPath);

    $this->assertStringContainsString(
        "'role' => \\Spatie\\Permission\\Middleware\\RoleMiddleware::class",
        $configContent
    );
})->group('Opdracht14');

test('PermissionMiddleware is registered in bootstrap/app.php', function () {
    $configPath = base_path('bootstrap/app.php');
    $configContent = file_get_contents($configPath);

    $this->assertStringContainsString(
        "'permission' => \\Spatie\\Permission\\Middleware\\PermissionMiddleware::class",
        $configContent
    );
})->group('Opdracht14');

test('RoleOrPermissionMiddleware is registered in bootstrap/app.php', function () {
    $configPath = base_path('bootstrap/app.php');
    $configContent = file_get_contents($configPath);

    $this->assertStringContainsString(
        "'role_or_permission' => \\Spatie\\Permission\\Middleware\\RoleOrPermissionMiddleware::class",
        $configContent
    );
})->group('Opdracht14');

// de view kan niet getest worden omdat de response geen view is bij de 403
test('custom 403 error page is displayed for unauthorized access', function () {
    Auth::logout(); // Ensure the user is logged out
    $response = $this->get('/admin/projects');
    $response->assertStatus(403);
    $response->assertSee('User is not logged in');
})->group('Opdracht14');

test('admin is redirected to home page after login', function () {
    $user = User::where('email', 'admin@school.nl')->first();

    // Controleer of de gebruiker correct is opgehaald
    expect($user)->not->toBeNull();

    // Simuleer een POST request naar de login route met de admin gebruikersgegevens
    $response = $this->post('/login', [
        'email' => 'admin@school.nl',
        'password' => 'admin'
    ]);

    // Assert dat de gebruiker correct wordt doorgestuurd naar de home route
    $response->assertRedirect(route('home'));

    // Controleer of de gebruiker is geauthenticeerd
    $this->assertAuthenticatedAs($user);
})->group('Opdracht14');

test('teacher is redirected to home page after login', function () {
    $user = User::where('email', 'teacher@school.nl')->first();

    // Controleer of de gebruiker correct is opgehaald
    expect($user)->not->toBeNull();

    // Simuleer een POST request naar de login route met de admin gebruikersgegevens
    $response = $this->post('/login', [
        'email' => 'teacher@school.nl',
        'password' => 'teacher'
    ]);

    // Assert dat de gebruiker correct wordt doorgestuurd naar de home route
    $response->assertRedirect(route('home'));

    // Controleer of de gebruiker is geauthenticeerd
    $this->assertAuthenticatedAs($user);
})->group('Opdracht14');

test('student is redirected to home page after login', function () {
    $user = User::where('email', 'student@school.nl')->first();

    // Controleer of de gebruiker correct is opgehaald
    expect($user)->not->toBeNull();

    // Simuleer een POST request naar de login route met de admin gebruikersgegevens
    $response = $this->post('/login', [
        'email' => 'student@school.nl',
        'password' => 'student'
    ]);

    // Assert dat de gebruiker correct wordt doorgestuurd naar de home route
    $response->assertRedirect(route('home'));

    // Controleer of de gebruiker is geauthenticeerd
    $this->assertAuthenticatedAs($user);
})->group('Opdracht14');

test('home page shows login and register links for guests', function () {
    Auth::logout(); // Ensure the user is logged out
    $response = $this->get('/');

    // Controleer op de aanwezigheid van de href attributen voor login en register
    $response->assertSee('href="' . route('login') . '"', false);
    $response->assertSee('href="' . route('register') . '"', false);
})->group('Opdracht14');

test('home page hides login and register links and shows logout link and username when logged in', function () {
    $user = User::where('email', 'student@school.nl')->first();
    $this->actingAs($user);
    $response = $this->get('/');

    // Controleer dat login en register links niet zichtbaar zijn
    $response->assertDontSee('href="' . route('login') . '"', false);
    $response->assertDontSee('href="' . route('register') . '"', false);

    // Controleer dat de logout link en de gebruikersnaam wel zichtbaar zijn
    $response->assertSee('href="' . route('logout') . '"', false);
    $response->assertSee($user->name);
})->group('Opdracht14');

// Test that student can access admin projects
test('student can access admin projects', function () {
    $student = User::where('email', 'student@school.nl')->first();
    $this->actingAs($student)
        ->get(route('projects.index'))
        ->assertStatus(200); // Student should have access
})->group('Opdracht14');

// Test that teacher can access admin projects
test('teacher can access admin projects', function () {
    $teacher = User::where('email', 'teacher@school.nl')->first();
    $this->actingAs($teacher)
        ->get(route('projects.index'))
        ->assertStatus(200); // Teacher should have access
})->group('Opdracht14');

// Test that admin can access admin projects
test('admin can access admin projects', function () {
    $admin = User::where('email', 'admin@school.nl')->first();
    $this->actingAs($admin)
        ->get(route('projects.index'))
        ->assertStatus(200); // Admin should have access
})->group('Opdracht14');

// Test that unauthenticated users cannot access admin projects
test('unauthenticated users cannot access admin projects', function () {
    Auth::logout(); // Zorg ervoor dat de gebruiker is uitgelogd
    $response = $this->get(route('projects.index'))
        ->assertStatus(403) // Verwacht een 403 statuscode
        ->assertSee('User is not logged in.'); // Controleer of de juiste foutpagina wordt weergegeven
})->group('Opdracht14');
