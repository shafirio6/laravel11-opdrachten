<?php

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use \Pest\Laravel;

beforeEach(function (){
    $this->project = Project::factory()->create();
    $this->seed('ProjectSeeder');
});

test('the visitor can view the public homepage', function()
{
    $this->withoutExceptionHandling();
    $this->get(route('home'))
        ->assertViewIs('layouts.layoutpublic')
        ->assertStatus(200);
})->group('Opdracht10');
