<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class TaskController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('index task'), only: ['index']),
            new Middleware(PermissionMiddleware::using('show task'), only: ['show']),
            new Middleware(PermissionMiddleware::using('create task'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('edit task'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('delete task'), only: ['delete', 'destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $tasks = Task::all();
        $tasks = Task::with('user', 'activity', 'project')->paginate(15);

        return view('admin.tasks.index', ['tasks'=> $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $projects = Project::all();
        $activities = Activity::all();

        return view('admin.tasks.create', [
            'users' => $users,
            'activities' => $activities,
            'projects' => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $tasks = new Task();
        $tasks->task = $request->input('task');
        $tasks->begindate = $request->input('begindate'); // Gebruik nu de request waarde
        $tasks->enddate = $request->input('enddate');
        $tasks->user_id = $request->input('user_id');
        $tasks->project_id = $request->input('project_id');
        $tasks->activity_id = $request->input('activity_id');
        $tasks->save();

        return to_route('tasks.index')->with('status', "Taak: $tasks->task is aangemaakt");
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('admin.tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::all();
        $projects = Project::all();
        $activities = Activity::all();

        return view('admin.tasks.edit', [
            'task' => $task,
            'users' => $users,
            'activities' => $activities,
            'projects' => $projects,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskStoreRequest $request, Task $task)
    {
        $task->task = $request->task;
        $task->begindate = $request->begindate;
        $task->enddate = $request->enddate;
        $task->user_id = $request->user_id;
        $task->project_id = $request->project_id;
        $task->activity_id = $request->activity_id;
        $task->save();

        return to_route('tasks.index')->with('status', "Taak: $task->task is bijgewerkt");
    }

    public function delete(Task $task)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
