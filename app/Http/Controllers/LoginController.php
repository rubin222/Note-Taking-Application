<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // returns login.blade.php view and displays the login form when someone visits /login
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login via web (session-based),validates them 
    public function loginWeb(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password'); //extracts only email and password fields from the requests

        if (Auth::attempt($credentials)) { //tries to login using those credentials and if success it regenerates the session ID and redirects user to the dashboard
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([ //if login fails sends error back to login form and keeps the entered email
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // returns register.blade.php view and displays the registration form when someone visits /register
    public function showRegisterForm()
    {
        return view('register');
    }

    // Handle register via web, validates them 
    public function registerWeb(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); //immediately logs in the user after registration and redirects to the dashboard
        return redirect()->route('dashboard');
    }

    // returns dashboard.blade.php view and shown only to logged in users
    public function dashboard()
    {
        return view('dashboard');
    }

    // Logout
    public function logoutWeb(Request $request)
    {
        Auth::logout(); //removes users authentication
        $request->session()->invalidate(); //clears all session data
        $request->session()->regenerateToken(); //regerates CSRF token
        return redirect()->route('login'); //redirects to login page
    }
}