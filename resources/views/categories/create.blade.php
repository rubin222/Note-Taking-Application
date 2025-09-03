@extends('layouts.app')     <!--tells laravel to use layout file app.blade.php-->

@section('content')  <!--starts content section of blade template-->
<div class="px-4 py-6 sm:px-0">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Create New Category</h1> <!--displays page title-->
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('categories.store') }}" method="POST"> <!--form submission URL route named categories.store-->
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
                
                <div class="flex justify-end space-x-4">  <!--redirects to categories.index-->
                    <a href="{{ route('categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection