@extends('layouts.layoutadmin')

@section('topmenu')
    <nav class="card">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="{{ route('projects.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Product</a>
                            <a href="{{ route('projects.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Product Toevoegen</a>
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
            <h1 class="h6">Project Admin</h1>
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
                        <th class="px-4 py-3">Naam</th>
                        <th class="px-4 py-3">Details</th>
                        <th class="px-4 py-3">Edit</th>
                        <th class="px-4 py-3">Delete</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @foreach($projects as $project)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-sm">{{ $project->id }}</td>
                            <td class="px-4 py-3 text-sm">{{ $project->name }}</td>
                            <td class="px-4 py-3 text-sm"><a href="{{route('projects.show', ['project' => $project->id])}}">Details</a></td>

                            <td class="px-4 py-3">
                                @can('edit project')
                                <div class="flex items-center space-x-4 text-sm">
                                    <a href="{{route('projects.edit', ['project' => $project->id])}}">Wijzigen</a>
                                </div>
                                @endcan
                            </td>

                            <td>
                                @can('delete project')
                                <div class="flex items-center space-x-4 text-sm">
                                    <a href="{{route('projects.delete', ['project' => $project->id])}}">verwijderen</a>
                                </div>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="container max-w-4xl mx-auto pb-10 flex justify-between items-center px-3">
                <div class="text-xs">

                </div>
            </div>
        </div>
        <!-- end body -->
    </div>
@endsection
