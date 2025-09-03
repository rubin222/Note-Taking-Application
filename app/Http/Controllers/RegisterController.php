<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        // Clear old input when showing registration form
        if (session()->has('_old_input')) {
            session()->forget('_old_input');
        }

        return view('register');
    }

    public function register(Request $request)
    {
        // Validation with  messages
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:users,name|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.regex' => 'Username may only contain letters, numbers, and underscores.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);
 
        if ($validator->fails()) {      //if validation fails redirect back to form, sends validation and preserves old input
            return back()->withErrors($validator)->withInput();
        }

        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate JWT token for the new user
        $token = JWTAuth::fromUser($user);

        // Clear old input
        $request->session()->forget('_old_input');

        // Redirect to dashboard 
        return redirect()->route('dashboard')
                         ->withCookie(cookie('jwt_token', $token, 60))    // stores JWT token in a cookie for 60 min and sendssuccess message to the dashboard
                         ->with('success', 'Registration successful! Welcome to your dashboard.');
    }
}
