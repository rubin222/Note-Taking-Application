<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Taking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gray-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">NoteApp</span>
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                            <i class=""></i> Categories
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="mr-4">Welcome, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-gray-700 hover:bg-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- SUCCESS/ERROR MESSAGES - ONLY ONCE IN LAYOUT -->
        <!-- @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif -->
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @yield('content')
    </main>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this?');
        }
    </script>
</body>
</html>