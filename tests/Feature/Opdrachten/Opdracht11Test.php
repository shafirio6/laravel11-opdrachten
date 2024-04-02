<?php

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use \Pest\Laravel;

beforeEach(function (){
//    $this->seed('RoleAndPermissionSeeder');
//    $this->seed('UserSeeder');
    $this->project = Project::factory()->create();
    $this->seed('ProjectSeeder');
});

test('the visitor can view the public projects page', function()
{
    $this->withoutExceptionHandling();
    $this
        ->get(route('open.projects.index'))
        ->assertViewIs('open.projects.index')
        ->assertSee($this->project->id)
        ->assertSee($this->project->name)
        ->assertSee(Str::limit($this->project->description, 350))
        ->assertStatus(200);
})->group('Opdracht11');





//
//test('the visitor can view the public projects page', function()
//{
//    $this->withoutExceptionHandling();
//    $this
//        ->get(route('public.projects.index'))
//        ->assertViewIs('open.projects.index')
//        ->assertSee($this->project->id)
//        ->assertSee($this->project->name)
//        ->assertSee(Str::limit($this->project->description, 350))
//        ->assertStatus(200);
//})->group('Opdracht11');
//
//test('the student user can view the public projects page', function()
//{
//    $this->withoutExceptionHandling();
//    $user = User::find(1);
//    Laravel\be($user)
//        ->get(route('public.projects.index'))
//        ->assertViewIs('open.projects.index')
//        ->assertSee($this->project->id)
//        ->assertSee($this->project->name)
//        ->assertSee(Str::limit($this->project->description, 350))
//        ->assertStatus(200);
//})->group('Opdracht11');
//
//test('the teacher user can view the public projects page', function()
//{
//    $this->withoutExceptionHandling();
//    $user = User::find(2);
//    Laravel\be($user)
//        ->get(route('public.projects.index'))
//        ->assertViewIs('open.projects.index')
//        ->assertSee($this->project->id)
//        ->assertSee($this->project->name)
//        ->assertSee(Str::limit($this->project->description, 350))
//        ->assertStatus(200);
//})->group('Opdracht11');
//
//test('the admin user can view the public projects page', function()
//{
//    $this->withoutExceptionHandling();
//    $user = User::find(3);
//    Laravel\be($user)
//        ->get(route('public.projects.index'))
//        ->assertViewIs('open.projects.index')
//        ->assertSee($this->project->id)
//        ->assertSee($this->project->name)
//        ->assertSee(Str::limit($this->project->description, 350))
//        ->assertStatus(200);
//})->group('Opdracht11');
//
//
