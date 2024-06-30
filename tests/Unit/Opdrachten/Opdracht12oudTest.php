<?php

use App\Models\User;
use Carbon\Carbon;

beforeEach(function (){
    $this->seed('RoleAndPermissionSeeder');
    $this->seed('UserSeeder');
});

test('the student user is correct in the database', function(){
    $user = User::find(1);
    expect($user->name)->toBe('student')
        ->and($user->email)->toBe('student@tcrmbo.nl');
})->group('Opdracht12oud');

test('the teacher user is correct in the database', function(){
    $user = User::find(2);
    expect($user->name)->toBe('teacher')
        ->and($user->email)->toBe('teacher@tcrmbo.nl');
})->group('Opdracht12oud');

test('the admin user is correct in the database', function(){
    $user = User::find(3);
    expect($user->name)->toBe('admin')
        ->and($user->email)->toBe('admin@tcrmbo.nl');
})->group('Opdracht12oud');



