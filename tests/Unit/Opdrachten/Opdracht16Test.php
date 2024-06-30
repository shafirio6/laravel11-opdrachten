<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Test of de Activity model bestaat
test('Activity model exists', function () {
    $this->assertTrue(class_exists(Activity::class));
})->group('Opdracht16');

// Test of de Task model bestaat
test('Task model exists', function () {
    $this->assertTrue(class_exists(Task::class));
})->group('Opdracht16');

// Test of de tasks table bestaat
test('tasks table exists', function () {
    $this->assertTrue(Schema::hasTable('tasks'));
})->group('Opdracht16');

// Test de kolommen van de tasks table
test('tasks table has correct columns', function () {
    $this->assertTrue(Schema::hasColumn('tasks', 'id'));
    $this->assertTrue(Schema::hasColumn('tasks', 'task'));
    $this->assertTrue(Schema::hasColumn('tasks', 'begindate'));
    $this->assertTrue(Schema::hasColumn('tasks', 'enddate'));
    $this->assertTrue(Schema::hasColumn('tasks', 'user_id'));
    $this->assertTrue(Schema::hasColumn('tasks', 'project_id'));
    $this->assertTrue(Schema::hasColumn('tasks', 'activity_id'));
    $this->assertTrue(Schema::hasColumn('tasks', 'created_at'));
    $this->assertTrue(Schema::hasColumn('tasks', 'updated_at'));
})->group('Opdracht16');

// Test de datatypes van de kolommen van de tasks table
test('tasks table has correct column types', function () {
    $this->assertEquals('integer', Schema::getColumnType('tasks', 'id'));
    $this->assertEquals('varchar', Schema::getColumnType('tasks', 'task'));
    $this->assertEquals('date', Schema::getColumnType('tasks', 'begindate'));
    $this->assertEquals('date', Schema::getColumnType('tasks', 'enddate'));
    $this->assertEquals('integer', Schema::getColumnType('tasks', 'user_id'));
    $this->assertEquals('integer', Schema::getColumnType('tasks', 'project_id'));
    $this->assertEquals('integer', Schema::getColumnType('tasks', 'activity_id'));
    $this->assertEquals('datetime', Schema::getColumnType('tasks', 'created_at'));
    $this->assertEquals('datetime', Schema::getColumnType('tasks', 'updated_at'));
})->group('Opdracht16');

// Test of de activities table bestaat
test('activities table exists', function () {
    $this->assertTrue(Schema::hasTable('activities'));
})->group('Opdracht16');

// Test de kolommen van de activities table
test('activities table has correct columns', function () {
    $this->assertTrue(Schema::hasColumn('activities', 'id'));
    $this->assertTrue(Schema::hasColumn('activities', 'name'));
    $this->assertTrue(Schema::hasColumn('activities', 'created_at'));
    $this->assertTrue(Schema::hasColumn('activities', 'updated_at'));
})->group('Opdracht16');

// Test de datatypes van de kolommen van de activities table
test('activities table has correct column types', function () {
    $this->assertEquals('integer', Schema::getColumnType('activities', 'id'));
    $this->assertEquals('varchar', Schema::getColumnType('activities', 'name'));
    $this->assertEquals('datetime', Schema::getColumnType('activities', 'created_at'));
    $this->assertEquals('datetime', Schema::getColumnType('activities', 'updated_at'));
})->group('Opdracht16');

// Test voor Task model relaties
test('Task model has user relationship', function () {
    $task = new Task();
    $this->assertInstanceOf(BelongsTo::class, $task->user());
})->group('Opdracht16');

test('Task model has project relationship', function () {
    $task = new Task();
    $this->assertInstanceOf(BelongsTo::class, $task->project());
})->group('Opdracht16');

test('Task model has activity relationship', function () {
    $task = new Task();
    $this->assertInstanceOf(BelongsTo::class, $task->activity());
})->group('Opdracht16');

// Test voor User model relatie
test('User model has tasks relationship', function () {
    $user = new User();
    $this->assertInstanceOf(HasMany::class, $user->tasks());
})->group('Opdracht16');

// Test voor Project model relatie
test('Project model has tasks relationship', function () {
    $project = new Project();
    $this->assertInstanceOf(HasMany::class, $project->tasks());
})->group('Opdracht16');

// Test voor Activity model relatie
test('Activity model has tasks relationship', function () {
    $activity = new Activity();
    $this->assertInstanceOf(HasMany::class, $activity->tasks());
})->group('Opdracht16');

// Test voor database relaties in de tasks table
test('tasks table has correct foreign key constraints', function () {
    $foreignKeys = DB::select('PRAGMA foreign_key_list(tasks)');

    $constraints = [
        ['from' => 'user_id', 'table' => 'users', 'to' => 'id', 'on_delete' => 'NO ACTION', 'on_update' => 'NO ACTION'],
        ['from' => 'project_id', 'table' => 'projects', 'to' => 'id', 'on_delete' => 'CASCADE', 'on_update' => 'CASCADE'],
        ['from' => 'activity_id', 'table' => 'activities', 'to' => 'id', 'on_delete' => 'RESTRICT', 'on_update' => 'RESTRICT'],
    ];

    foreach ($constraints as $constraint) {
        $exists = false;
        foreach ($foreignKeys as $foreignKey) {
            if (
                $foreignKey->from === $constraint['from'] &&
                $foreignKey->table === $constraint['table'] &&
                $foreignKey->to === $constraint['to'] &&
                $foreignKey->on_delete === $constraint['on_delete'] &&
                $foreignKey->on_update === $constraint['on_update']
            ) {
                $exists = true;
                break;
            }
        }
        $this->assertTrue($exists, "Missing or incorrect foreign key constraint: " . json_encode($constraint));
    }
})->group('Opdracht16');
