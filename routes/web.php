<?php

use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\open as Open;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProjectController;

//Route::prefix('admin')->name('projects.')->group(function () {
//    Route::resource('projects', ProjectController::class);
//});

Route::get('/', function () {
    return view('layouts.layoutpublic');
})->name('home');

Route::get('/admin', function () {
    return view('layouts.layoutadmin');
})->name('admin');

Route::get('/projects', [Open\ProjectController::class, 'index'])->name('open.projects.index');

Route::resource('admin/projects', Admin\ProjectController::class);
Route::get( '/Admin/project/{project}/delete', [Admin\ProjectController::class, 'delete'])->name('projects.delete');

Route::group(['middleware' => ['role:teacher|student|admin']], function () {
    Route::get('/admin/projects/{projects},/delete', [Admin\ProjectController::class, 'delete'])
        ->name('admin.projects.delete');
    Route::resource('admin/projects', Admin\ProjectController::class);

    Route::get('dashboard',function(){
        return view('dashboard');
    })-> middleware(['auth','verified'])->name('dashboard');
});

Route::get( '/admin/tasks/{task}/delete', [Admin\TaskController::class, 'delete'])->name('tasks.delete');
Route::resource('admin/tasks', Admin\TaskController::class);





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
