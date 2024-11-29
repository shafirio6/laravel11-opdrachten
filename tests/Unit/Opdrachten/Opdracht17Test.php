<?php

use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
    $this->seed('ProjectSeeder');
});

// Test of de activities table gevuld wordt met data
test('activities table can be seeded with data from factory', function () {
    Activity::factory()->count(10)->create();
    $this->assertGreaterThan(0, Activity::count());
})->group('Opdracht17');

// Test of de Activity factory werkt
test('Activity factory creates valid data', function () {
    $activity = Activity::factory()->create();

    // Controleer of het record is aangemaakt
    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'name' => $activity->name
    ]);

    // Controleer of de gegenereerde data de juiste datatypes en lengtes hebben
    $this->assertIsString($activity->name);
    $this->assertLessThanOrEqual(25, strlen($activity->name));
})->group('Opdracht17');




// Test of de Task factory werkt
test('Task factory creates valid data', function () {
    $activity = Activity::factory()->create();
    $task = Task::factory()->create();

    // Controleer of het record is aangemaakt
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
    ]);

    // Controleer of de gegenereerde data de juiste datatypes en lengtes hebben
    $this->assertIsString($task->task);
    $this->assertGreaterThanOrEqual(10, strlen($task->task));
    $this->assertLessThanOrEqual(200, strlen($task->task));

    $this->assertInstanceOf(Carbon::class, Carbon::parse($task->begindate));
    $this->assertInstanceOf(Carbon::class, Carbon::parse($task->enddate));
    $this->assertTrue(Carbon::parse($task->enddate)->greaterThanOrEqualTo(Carbon::parse($task->begindate)->addDays(10)));

    $this->assertIsInt($task->user_id);
    $this->assertIsInt($task->project_id);
    $this->assertIsInt($task->activity_id);
})->group('Opdracht17');

// Test dat de Task factory geldige relaties maakt
test('Task factory creates valid relationships', function () {
    $activity = Activity::factory()->create();
    $task = Task::factory()->create();

    // Controleer of de gerelateerde records bestaan
    $this->assertDatabaseHas('users', [
        'id' => $task->user_id,
    ]);
    $this->assertDatabaseHas('projects', [
        'id' => $task->project_id,
    ]);
    $this->assertDatabaseHas('activities', [
        'id' => $task->activity_id,
    ]);
})->group('Opdracht17');

// Test dat de gegenereerde data voldoet aan de veldgroottes
test('Task factory data fits within field sizes', function () {
    $activity = Activity::factory()->create();
    $task = Task::factory()->create();

    $this->assertLessThanOrEqual(200, strlen($task->task));
    $this->assertInstanceOf(Carbon::class, Carbon::parse($task->begindate));
    $this->assertInstanceOf(Carbon::class, Carbon::parse($task->enddate));

    $this->assertIsInt($task->user_id);
    $this->assertIsInt($task->project_id);
    $this->assertIsInt($task->activity_id);
})->group('Opdracht17');
