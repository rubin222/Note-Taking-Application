@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Category: <span class="inline-block px-3 py-1 text-white rounded-full" style="background-color: {{ $category->color }}">{{ $category->name }}</span></h1>
            <div class="flex space-x-2">
                <a href="{{ route('categories.edit', $category) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Notes in this category ({{ $category->notes->count() }})</h2>
            
            @if($category->notes->count() > 0)
                <div class="space-y-4">
                    @foreach($category->notes as $note)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold">{{ $note->title }}</h3>
                            <p class="text-gray-600 mt-2">{{ Str::limit($note->content, 150) }}</p>
                            <div class="mt-2 text-sm text-gray-500">
                                Created: {{ $note->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No notes in this category yet.</p>
            @endif
        </div>

        <a href="{{ route('categories.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            <i class="fas fa-arrow-left mr-1"></i> Back to Categories
        </a>
    </div>
</div>
@endsection