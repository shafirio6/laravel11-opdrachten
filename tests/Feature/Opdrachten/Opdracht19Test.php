<?php

use App\Http\Controllers\Admin\TaskController;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ActivitySeeder');
    $this->seed('ProjectSeeder');
    $this->seed('TaskSeeder');
});

// Test of de tasks index pagina toegankelijk is voor niet-ingelogde gebruikers
test('tasks index page is accessible for non-authenticated users', function () {
    $response = $this->get(route('tasks.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.tasks.index');
})->group('Opdracht19');

// Test of de tasks index pagina de correcte data weergeeft
test('tasks index page displays correct data', function () {
    $tasks = Task::with(['user', 'project', 'activity'])->paginate(15);
    $response = $this->get(route('tasks.index'));

    foreach ($tasks as $task) {
        $response->assertSee((string) $task->id);
        $response->assertSee(Str::limit($task->task, 50));
        $response->assertSee($task->begindate);
        $response->assertSee($task->enddate ? $task->enddate : '');
        $response->assertSee($task->user ? $task->user->name : 'N/A');
        $response->assertSee($task->project->name);
        $response->assertSee($task->activity->name);
    }
})->group('Opdracht19');

// Test of de tasks index pagina niet-inclusieve gebruikersnaam weergeeft als N/A
test('tasks index page displays N/A for non-associated user', function () {
    $task = Task::factory()->create(['user_id' => null]);
    // Haal het totale aantal pagina's op
    $totalTasks = Task::count();
    $tasksPerPage = 15;
    $lastPage = (int) ceil($totalTasks / $tasksPerPage);

    // Haal de laatste pagina op en controleer de aanwezigheid van 'N/A'
    $response = $this->get(route('tasks.index', ['page' => $lastPage]));
    $response->assertSee('N/A');
})->group('Opdracht19');

// Test of de paginering werkt op de tasks index pagina
test('tasks index page pagination works', function () {
    $initialTaskCount = Task::count(); // Aantal taken dat al door de seeders is aangemaakt
    $totalTasksToAdd = 30;
    Task::factory()->count($totalTasksToAdd)->create();

    $response = $this->get(route('tasks.index'));

    // Bepaal het totale aantal pagina's op basis van de totale taken
    $totalTasks = $initialTaskCount + $totalTasksToAdd;
    $tasksPerPage = 15;
    $totalPages = (int) ceil($totalTasks / $tasksPerPage);

    // Controleer of de juiste paginering links zichtbaar zijn
    for ($page = 1; $page <= $totalPages; $page++) {
        if ($page > 1) {
            $response->assertSee('href="' . route('tasks.index') . '?page=' . $page . '"', false);
        }
    }
})->group('Opdracht19');

// Test of de show-, edit-, en delete-links correct worden weergegeven op de tasks index pagina
test('tasks index page displays show, edit, and delete links', function () {
    $task = Task::first();
    $response = $this->get(route('tasks.index'));

    $response->assertSee('href="' . route('tasks.show', $task->id) . '"', false);
    $response->assertSee('href="' . route('tasks.edit', $task->id) . '"', false);
    $response->assertSee('href="' . route('tasks.delete', $task->id) . '"', false);
})->group('Opdracht19');

// Test of de delete-methode bestaat in de TaskController
test('TaskController has delete method', function () {
    $this->assertTrue(method_exists(TaskController::class, 'delete'), 'TaskController does not have a delete method.');
})->group('Opdracht19');
