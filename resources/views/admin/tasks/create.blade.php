@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="{{ route('tasks.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Task</a>
                            <a href="{{ route('tasks.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Task Toevoegen</a>
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
        <h1 class="h6">Taak Admin</h1>
    </div>

    <!-- errors -->
    @if($errors->any())
    <div class="bg-red-200 text-red-900 rounded-lg shadow-md p-6 pr-10 mb-8">
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- body -->
    <div class="card-body grid grid-cols-1 gap-6 lg:grid-cols-1">
        <div class="p-4">
            <form action="{{ route('tasks.store') }}" method="POST"
                  class="shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
                @csrf

                <!-- Task -->
                <label class="block text-sm">
                    <span class="text-gray-700">Task</span>
                    <input   class="bg-gray-200 block rounded w-full p-2 mt-1
                               focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                             type="text" name="task" value="{{ old('task') }}" required
                         >
                </label>

                <!-- Begindate -->
                <label class="block text-sm mt-4">
                    <span class="text-gray-700">Begindate</span>
                    <input   class="bg-gray-200 block rounded w-full p-2 mt-1
                               focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                             type="date" name="begindate" value="{{ old('begindate') }}" required
                         >
                </label>

                <!-- Enddate -->
                <label class="block text-sm mt-4">
                    <span class="text-gray-700">Enddate</span>
                    <input class="bg-gray-200 block rounded w-full p-2 mt-1
                    focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    type="date" name="enddate" value="{{ old('enddate') }}">
                </label>

                <!-- User -->
                <label class="block text-sm mt-4">
                    <span class="text-gray-700">User</span>
                    <select name="user_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                                focus:outline-none focus:shadow-outline">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}"@selected($user->id == old('user_id'))>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </label>

                <!-- Activity -->
                <label class="block text-sm mt-4">
                    <span class="text-gray-700">Activity</span>
                    <select name="activity_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                                focus:outline-none focus:shadow-outline">
                        @foreach($activities as $activity)
                        <option value="{{ $activity->id }}"@selected($activity->id == old('activity_id'))>{{ $activity->name }}</option>
                        @endforeach
                    </select>
                </label>

                <!-- Project -->
                <label class="block text-sm mt-4">
                    <span class="text-gray-700">Project</span>
                    <select name="project_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                                focus:outline-none focus:shadow-outline">
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}"@selected($project->id == old('project_id'))>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </label>

                <!-- Submit -->
                <button type="submit"
                        class="mt-6 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150
                            bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700
                            focus:outline-none focus:shadow-outline-purple">
                    Taak Toevoegen
                </button>
            </form>
        </div>
    </div>
</div>
@endsection


