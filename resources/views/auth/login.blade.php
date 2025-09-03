<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NoteMan</title>
    <!-- tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-400 to-teal-500 min-h-screen flex items-center justify-center">

    <!-- Main Card -->
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md">
        
        <!-- App Name -->
        <h1 class="text-3xl font-extrabold text-center text-indigo-600 mb-4">NoteMan</h1>
        
        <!-- Page Title -->
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Welcome Back</h2>

        <!-- Success Message: checks if session has success message and displays with green alert box-->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages: checks for validation error and displays them in a red box -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form: form submits to login route, uses POST request,blade CSRF token -->
        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf
            
            <!--Email input field -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="Enter your email" required>
            </div>

            <!-- Password input field-->
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="Enter your password" required>
            </div>

            <!-- Submit Button for login-->
            <button type="submit"
                class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                Login
            </button>
        </form>

        <!--Register Link: shows link to registration page -->
        <p class="text-center mt-6 text-gray-600">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:text-indigo-800">Register here</a>
        </p>
    </div>
</body>
</html>
