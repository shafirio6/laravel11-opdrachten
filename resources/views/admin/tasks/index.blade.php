@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="{{ route('tasks.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Product</a>
                            <a href="{{ route('tasks.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Product Toevoegen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endsection

@section('content')
    <div class="card mt-6">
        <!-- header -->
        <div class="card-header flex flex-row justify-between">
            <h1 class="h6">Product Admin</h1>
        </div>
        <!-- end header -->
        @if(session('status'))
            <div class="card-body">
                <div class="bg-green-400 text-green-800 rounded-lg shadow-md p-6 pr-10 mb-8" style="min-width: 240px">{{ session('status') }}</div>
            </div>
        @endif
        @if(session('status-wrong'))
            <div class="card-body">
                <div class="bg-red-400 text-red-800 rounded-lg shadow-md p-6 pr-10 mb-8" style="min-width: 240px">{{ session('status-wrong') }}</div>
            </div>
        @endif
        <!-- body -->
        <div class="card-body grid grid-cols-1 gap-6 lg:grid-cols-1">
            <div class="p-4">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                        <th class="px-4 py-3">Id</th>
                        <th class="px-4 py-3">Task</th>
                        <th class="px-4 py-3">Begindate</th>
                        <th class="px-4 py-3">Enddate</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Activity</th>
                        <th class="px-4 py-3">Edit</th>
                        <th class="px-4 py-3">Delete</th>
                        <th class="px-4 py-3">Details</th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @foreach($tasks as $task)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-sm">{{ $task->id}}</td>
                            <td class="px-4 py-3 text-sm">{{ \Illuminate\Support\str::limit( $task->task,50)}}</td>
                            <td class="px-4 py-3 text-sm">{{ $task->begindate}}</td>
                            <td class="px-4 py-3 text-sm">{{ $task->enddate}}</td>
                            <td class="px-4 py-3 text-sm">{{ $task->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $task->project->name}}</td>
                            <td class="px-4 py-3 text-sm">{{ $task->activity->name}}</td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('tasks.show', ['task'=> $task->id]) }}">Details</a>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <a href="{{ route('tasks.edit', ['task'=> $task->id]) }}">Wijzigen</a>
                                </div>
                            </td>
                            <td>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a href="{{ route('tasks.delete', ['task'=> $task->id]) }}">
                                            Verwijderen</a>
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="container max-w-4xl mx-auto pb-10 flex justify-between items-center px-3">
                <div class="text-xs">
                    {{ $tasks->Links() }}
                </div>
            </div>
        </div>
        <!-- end body -->
    </div>
@endsection
