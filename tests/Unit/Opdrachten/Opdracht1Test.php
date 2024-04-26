<?php
use App\Models\Project;
use Illuminate\Support\Facades\Schema;

test('De tabel projects bestaat', function () {
    $this->assertTrue(Schema::hasTable('projects'));
})->group('Opdracht1');

test('De tabel projects heeft de juiste kolommen', function () {
    $this->assertTrue(Schema::hasColumns('projects', [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at'
    ]));
})->group('Opdracht1');

test('De kolommen in tabel projects hebben de juiste datatype en grootte', function () {
    $this->assertEquals('integer', Schema::getColumnType('projects', 'id'));
    $this->assertEquals('varchar', Schema::getColumnType('projects', 'name'));
    $this->assertEquals('text', Schema::getColumnType('projects', 'description'));
    $this->assertEquals('datetime', Schema::getColumnType('projects', 'created_at'));
    $this->assertEquals('datetime', Schema::getColumnType('projects', 'updated_at'));
})->group('Opdracht1');

