<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
});

test('De tabel activity bestaat', function () {
    $this->assertTrue(Schema::hasTable('activities'));
})->group('Opdracht14oud');

test('De tabel activities heeft de juiste kolommen', function () {
    $this->assertTrue(Schema::hasColumns('activities', [
        'id',
        'name',
        'created_at',
        'updated_at'
    ]));
})->group('Opdracht14oud');

test('De kolommen in tabel activities hebben de juiste datatype en grootte', function () {
    $this->assertEquals('integer', Schema::getColumnType('activities', 'id'));
    $this->assertEquals('string', Schema::getColumnType('activities', 'name'));
    $this->assertEquals('datetime', Schema::getColumnType('activities', 'created_at'));
    $this->assertEquals('datetime', Schema::getColumnType('activities', 'updated_at'));
})->group('Opdracht14oud');


test('De tabel tasks bestaat', function () {
    $this->assertTrue(Schema::hasTable('tasks'));
})->group('Opdracht14oud');

test('De tabel tasks heeft de juiste kolommen', function () {
    $this->assertTrue(Schema::hasColumns('tasks', [
        'id',
        'task',
        'begindate',
        'enddate',
        'user_id',
        'project_id',
        'activity_id',
        'created_at',
        'updated_at'
    ]));
})->group('Opdracht14oud');

test('De kolommen in tabel tasks hebben de juiste datatype en grootte', function () {
    $this->assertEquals('integer', Schema::getColumnType('tasks', 'id'));
    $this->assertEquals('string', Schema::getColumnType('tasks', 'task'));
    $this->assertEquals('datetime', Schema::getColumnType('tasks', 'begindate'));
    $this->assertEquals('datetime', Schema::getColumnType('tasks', 'enddate'));
    $this->assertEquals('integer', Schema::getColumnType('tasks', 'activity_id'));
    $this->assertEquals('integer', Schema::getColumnType('tasks', 'project_id'));
    $this->assertEquals('integer', Schema::getColumnType('tasks', 'user_id'));
    $this->assertEquals('datetime', Schema::getColumnType('tasks', 'created_at'));
    $this->assertEquals('datetime', Schema::getColumnType('tasks', 'updated_at'));
})->group('Opdracht14oud');


