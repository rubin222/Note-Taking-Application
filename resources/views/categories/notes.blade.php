@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Notes in 
                <span class="inline-block px-3 py-1 text-white rounded-full" style="background-color: {{ $category->color }}">
                    {{ $category->name }}
                </span>
            </h1>
            <p class="text-gray-600 mt-1">Manage your notes in this category</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-arrow-left mr-1"></i> Back to Categories
            </a>
            <button onclick="document.getElementById('createNoteModal').classList.remove('hidden')" 
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-plus mr-1"></i> Add Note
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <form action="{{ route('categories.notes', $category) }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ $search }}" 
                placeholder="Search notes by title..." 
                class="flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-search"></i> Search
            </button>
            @if($search)
                <a href="{{ route('categories.notes', $category) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Notes List -->
    @if($notes->count() > 0)
        <div class="grid grid-cols-1 gap-6">
            @foreach($notes as $note)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold">
                                @if($search)
                                    <!-- Highlight search term in title -->
                                    {!! str_replace($search, '<span class="bg-yellow-200">' . $search . '</span>', $note->title) !!}
                                @else
                                    {{ $note->title }}
                                @endif
                            </h3>
                            <span class="text-sm text-gray-500">{{ $note->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <p class="text-gray-600 mb-4 whitespace-pre-line">{{ $note->content }}</p>
                        
                        <div class="flex justify-end space-x-2">
                            <button onclick="openEditModal({{ json_encode($note) }})" 
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this note?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $notes->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-sticky-note text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">
                @if($search)
                    No notes found for "{{ $search }}"
                @else
                    No notes in this category yet
                @endif
            </h3>
            <p class="text-gray-600 mb-4">
                @if($search)
                    Try a different search term or clear the search.
                @else
                    Get started by adding your first note to this category!
                @endif
            </p>
            @if($search)
                <a href="{{ route('categories.notes', $category) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md mr-2">
                    <i class="fas fa-times mr-1"></i> Clear Search
                </a>
            @endif
            <button onclick="document.getElementById('createNoteModal').classList.remove('hidden')" 
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-plus mr-1"></i> Add Note
            </button>
        </div>
    @endif
</div>

<!-- Create Note Modal -->
<div id="createNoteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add Note to {{ $category->name }}</h3>
            <form action="{{ route('notes.store', $category) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" name="title" id="title" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                    <textarea name="content" id="content" rows="5" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="document.getElementById('createNoteModal').classList.add('hidden')" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Add Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Note Modal -->
<div id="editNoteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Note</h3>
            <form id="editNoteForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" name="title" id="edit_title" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="mb-4">
                    <label for="edit_content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                    <textarea name="content" id="edit_content" rows="5" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="document.getElementById('editNoteModal').classList.add('hidden')" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:blue-700 text-white px-4 py-2 rounded-md">
                        Update Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(note) {
    document.getElementById('editNoteForm').action = `/notes/${note.id}`;
    document.getElementById('edit_title').value = note.title;
    document.getElementById('edit_content').value = note.content;
    document.getElementById('editNoteModal').classList.remove('hidden');
}
</script>
@endsection