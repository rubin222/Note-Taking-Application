@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Categories</h1>
        <button onclick="document.getElementById('createCategoryModal').classList.remove('hidden')" 
            class="bg-gray-600 hover:bg--700 text-white px-4 py-2 rounded-md">
            <i class="fas fa-plus mr-1"></i> New Category
        </button>
    </div>

    <!-- Search Bar for Notes Across All Categories -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <form action="{{ route('dashboard') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ $search }}" 
                placeholder="Search notes by title..." 
                class="flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-search"></i> Search
            </button>
            @if($search)
                <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Categories Grid -->
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-block px-3 py-1 text-sm font-semibold text-white rounded-full" 
                                style="background-color: {{ $category->color }}">
                                {{ $category->name }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $category->notes_count }} notes</span>
                        </div>
                        
                        <!-- Show matching notes if search is active -->
                        <!-- Show matching notes if search is active -->
@if($search)
    @if(isset($category->notes) && $category->notes->count() > 0)
        <div class="mb-4">
            <p class="text-sm font-semibold text-gray-700 mb-2">Matching notes:</p>
            <ul class="text-sm text-gray-600 space-y-1">
                @foreach($category->notes as $note)
                    <li class="flex items-center">
                        <i class="fas fa-sticky-note text-gray-400 mr-2"></i>
                        <span class="truncate">{!! str_ireplace($search, '<span class="bg-yellow-200 font-semibold">' . $search . '</span>', $note->title) !!}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <p class="text-sm text-gray-500 mb-4">No matching notes in this category.</p>
    @endif
@else
    <p class="text-gray-600 mb-4">Click to view and manage notes in this category</p>
@endif
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ route('categories.notes', $category) }}" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                                <i class="fas fa-sticky-note mr-1"></i> View Notes
                            </a>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('categories.edit', $category) }}" class="text-green-600 hover:text-green-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure? This will delete all notes in this category.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-tags text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">
                @if($search)
                    No categories found with notes matching "{{ $search }}"
                @else
                    No categories yet
                @endif
            </h3>
            <p class="text-gray-600 mb-4">
                @if($search)
                    Try a different search term or clear the search.
                @else
                    Create categories to organize your notes!
                @endif
            </p>
            @if($search)
                <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md mr-2">
                    <i class="fas fa-times mr-1"></i> Clear Search
                </a>
            @endif
            <button onclick="document.getElementById('createCategoryModal').classList.remove('hidden')" 
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                Create Category
            </button>
        </div>
    @endif
</div>

<!-- Create Category Modal -->
<div id="createCategoryModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Category</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="color" class="block text-gray-700 text-sm font-bold mb-2">Color</label>
                    <input type="color" name="color" id="color" value="#3B82F6"
                        class="w-full h-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="document.getElementById('createCategoryModal').classList.add('hidden')" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-yellow-200 {
        background-color: #fef9c3;
        padding: 0 2px;
        border-radius: 3px;
        display: inline;
    }
</style>
@endsection