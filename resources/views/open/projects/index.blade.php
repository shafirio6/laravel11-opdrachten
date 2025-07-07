@extends('layouts.layoutpublic')

@section('content')
    <h1 class="text-center text-2xl md:text-4xl px-6 py-12 bg-white">Projecten</h1>

    <div class="w-full px-6 py-8 bg-gray-100 border-t">
        <div class="container max-w-5xl mx-auto">

            <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Naam</th>
                    <th class="px-4 py-3 text-left">Beschrijving</th>
                </tr>
                </thead>
                <tbody class="text-gray-700">
                @foreach($projects as $project)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="px-4 py-3 text-sm">{{ $project->id }}</td>
                        <td class="px-4 py-3 text-sm">{{ $project->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ \Illuminate\Support\Str::limit($project->description, 350) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                {{ $projects->links() }}
            </div>

        </div>
    </div>
@endsection
