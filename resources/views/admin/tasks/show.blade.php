@extends('layouts.layoutadmin')
@section('topmenu')
    <nav class="card">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="{{ route('products.index') }}" class="text-gray-800 px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Overzicht Product</a>
                            <a href="{{ route('products.create') }}" class="text-gray-800 hover:text-teal-600 transition ease-in-out duration-500 px-3 py-2 rounded-md text-sm font-medium">Product Toevoegen</a>
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
        <!-- content -->
        <div class="py-4 px-6">
            <h2 class="text-sm font-semibold text-gray-800">Product details</h2>
            <p class="py-2 text-sm text-gray-700">Naam:  {{ $product->name }}</p>
            <p class="py-2 text-sm text-gray-700">Categorie:  {{ $product->category->name }}</p>
            <p class="py-2 text-sm text-gray-700">Beschrijving:<br>  {{ $product->description }}</p>

            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                    <th class="px-4 py-3">Id</th>
                    <th class="px-4 py-3">Prijs</th>
                    <th class="px-4 py-3">Datum</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y">
                @foreach($product->prices->sortByDesc('effdate') as $item)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-sm">{{ $item->id }}</td>
                        <td class="px-4 py-3 text-sm">{{ $item->price }}</td>
                        <td class="px-4 py-3 text-sm">{{ $item->effdate }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- end content -->
    </div>

@endsection
