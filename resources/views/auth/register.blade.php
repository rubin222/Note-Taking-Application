<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NoteMan</title>
    <!--tailwindcss-->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-400 to-teal-500 min-h-screen flex flex-col items-center justify-start pt-10">
     <p class="text-center text-white text-3xl font-bold mb-6">Please register to get started</p>

    <!--Main Card-->
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md">

        <!--App Name-->
        <h1 class="text-3xl font-extrabold text-center text-indigo-600 mb-4">NoteMan</h1>

        <!--Page Title-->
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Create Your Account</h2>

        <!--Error Message-->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!--Registration Form-->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Username -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-1">Username</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                    placeholder="Enter your username" required>
                <p class="text-xs text-gray-500 mt-1">Letters, numbers, and underscores only</p>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                    placeholder="Enter your email" required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                    placeholder="Enter your password" required>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                    placeholder="Confirm your password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-teal-600 text-white font-bold py-2 px-4 rounded-md hover:bg-teal-700 transition">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center mt-6 text-gray-600">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-teal-600 font-semibold hover:text-teal-800">Login here</a>
        </p>
    </div>
</body>
</html>
