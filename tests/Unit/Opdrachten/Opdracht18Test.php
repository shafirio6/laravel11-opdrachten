<?php

use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\ActivitySeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\TaskSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
});

// Test of de ActivitySeeder werkt
test('ActivitySeeder runs successfully', function () {
    $this->seed(ActivitySeeder::class);

    $this->assertDatabaseCount('activities', 5);
    $this->assertDatabaseHas('activities', ['id' => 1, 'name' => 'Todo']);
    $this->assertDatabaseHas('activities', ['id' => 2, 'name' => 'Doing']);
    $this->assertDatabaseHas('activities', ['id' => 3, 'name' => 'Testing']);
    $this->assertDatabaseHas('activities', ['id' => 4, 'name' => 'Verify']);
    $this->assertDatabaseHas('activities', ['id' => 5, 'name' => 'Done']);
})->group('Opdracht18');

// Test of de ProjectSeeder werkt
test('ProjectSeeder runs successfully', function () {
    $this->seed(ActivitySeeder::class);
    $this->seed(ProjectSeeder::class);

    $projectCount = Project::count();
    $this->assertTrue($projectCount >= 5, "Expected at least 5 projects, but found {$projectCount}");

    $taskCount = Task::count();
    $this->assertTrue($taskCount >= 10, "Expected at least 10 tasks, but found {$taskCount}");
})->group('Opdracht18');

// Test of de TaskSeeder werkt
test('TaskSeeder runs successfully', function () {
    $this->seed(ActivitySeeder::class);
    $this->seed(ProjectSeeder::class);
    $this->seed(TaskSeeder::class);

    $taskCount = Task::count();
    $this->assertTrue($taskCount >= 10, "Expected at least 10 tasks, but found {$taskCount}");

    // Controleer of elke taak een project en een activity heeft
    $tasks = Task::all();
    foreach ($tasks as $task) {
        $this->assertNotNull($task->project_id);
        $this->assertNotNull($task->activity_id);
    }
})->group('Opdracht18');

// Test dat de project relatie correct is opgezet in de tasks table
test('Task model has correct project relationship', function () {
    $this->seed(ActivitySeeder::class);
    $project = Project::factory()->create();
    $task = Task::factory()->create(['project_id' => $project->id]);

    $this->assertTrue($task->project()->exists());
    $this->assertEquals($task->project->id, $project->id);
})->group('Opdracht18');

// Test dat de activity relatie correct is opgezet in de tasks table
test('Task model has correct activity relationship', function () {
    $activity = Activity::factory()->create();
    $this->seed(ProjectSeeder::class);
    $task = Task::factory()->create(['activity_id' => $activity->id]);

    $this->assertTrue($task->activity()->exists());
    $this->assertEquals($task->activity->id, $activity->id);
})->group('Opdracht18');

// Test dat de user relatie correct is opgezet in de tasks table
test('Task model has correct user relationship', function () {
    $this->seed(ActivitySeeder::class);
    $this->seed(ProjectSeeder::class);
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $this->assertTrue($task->user()->exists());
    $this->assertEquals($task->user->id, $user->id);
})->group('Opdracht18');

// Test dat de seeders in de DatabaseSeeder staan en in de juiste volgorde worden uitgevoerd
test('DatabaseSeeder calls ActivitySeeder, ProjectSeeder, and TaskSeeder in correct order', function () {
    $databaseSeederContent = file_get_contents(database_path('seeders/DatabaseSeeder.php'));

    $this->assertStringContainsString('ActivitySeeder::class', $databaseSeederContent);
    $this->assertStringContainsString('ProjectSeeder::class', $databaseSeederContent);
    $this->assertStringContainsString('TaskSeeder::class', $databaseSeederContent);

    $activityPos = strpos($databaseSeederContent, 'ActivitySeeder::class');
    $projectPos = strpos($databaseSeederContent, 'ProjectSeeder::class');
    $taskPos = strpos($databaseSeederContent, 'TaskSeeder::class');

    $this->assertTrue($activityPos < $projectPos, "ActivitySeeder should be called before ProjectSeeder");
    $this->assertTrue($projectPos < $taskPos, "ProjectSeeder should be called before TaskSeeder");
})->group('Opdracht18');
