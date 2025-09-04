<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//it indicates laravel authentication system
use App\Models\User;
use App\Models\Note;
use App\Models\Category;
use Tymon\JWTAuth\Facades\JWTAuth;//it helps generate JWT tokens for login
use Illuminate\Support\Facades\Hash;//helps to securely hash passwords before saving them

class AuthController extends Controller
{
    //this portion shows auth.login page which is a blade template and in laravel when auth.login is written,
    //it will look for resources/views/auth/login.blade.php
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //same here for auth.register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle web login and method that handles login when user submits the form.
    public function webLogin(Request $request)
    {
        $request->validate([  //email is required and must be valid and password is required and must be at least 6 characters
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password'); //collects the email and password from the request

        //if the email/passowrd is correct, it log the user in, get in the logged user,
        //generates the JWT token, store them in a cookie and redirects to the dashboard with success message.

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);

            return redirect()->route('dashboard')
                ->withCookie(cookie('jwt_token', $token, 60))
                ->with('success', 'Login successful!');
        }

        //if login fails, it shows invalid credentials but keeps the entered email.

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');
    }

    // Handles web register where name is required,string max 255 and unique in users table
    //email is required,valid and unique
    //password is required,confirmed and min 6 characters and also must match with password_confirmation
public function webRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([          //creates new user with hashed password
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')     //redirects to login page with succcess message
            ->with('success', 'Registration successful! Please login.');
    }

    // Logout:it clears the session and JWT token . invalidate(): destroys all the session data
    //regenerateToken(): generates a new CSRF token
    //JWT is stored in cookie so the browser will send it with each request. If we don't delete it, 
    //browser will keep sending JWT , the users will stay logged in evem after logout
    //deleting cookies ensure the JWT can't be reused
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login')
            ->withCookie(cookie()->forget('jwt_token'))
            ->with('success', 'You have been logged out successfully.');
    }

    //
    public function dashboard(Request $request)
    {
           $user = Auth::user();    //gets the currently logged-in user

        // Get search query from request
        $search = $request->input('search');

        // Get user's notes that belongs only to logged-in user. If search exists, it filters note by title.
        //then loads catogory info, gives newest first 
        //then paginates which means result 10 pages at a time
        $notes = Note::where('user_id', $user->id)
            ->when($search, fn($query) => $query->where('title', 'like', "%$search%"))
            ->with('category')
            ->latest()
            ->paginate(10);

        // Get user's categories and return view with notes, categories and search.
        $categories = Category::where('user_id', $user->id)->get();

        return view('dashboard', compact('notes', 'categories', 'search'));
    }

    // Create new note, validate and store it
    public function storeNote(Request $request)
    {
    $request->validate([
        'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        Auth::user()->notes()->create($request->all()); //save the note for login user

        return redirect()->route('dashboard') //redirect to dashboard with success 
            ->with('success', 'Note created successfully.');
    }

    // Edit note (return edit form)
    public function editNote(Note $note)
    {
        $this->authorize('update', $note); // optional policy check
        $categories = Category::where('user_id', Auth::id())->get(); // Get user's categories, show edit view with the note and categories
        return view('notes.edit', compact('note', 'categories'));
    }

    // Update note
    //checks authorization before updating
    public function updateNote(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $request->validate([      
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $note->update($request->all()); //updates notes in the databas

        return redirect()->route('dashboard') //redirects with success message
            ->with('success', 'Note updated successfully.');
    }

    // Delete note
    public function deleteNote(Note $note) //checks permission
    {
        $this->authorize('delete', $note);
        $note->delete();
  
        return redirect()->route('dashboard') //redirect with confirmation
            ->with('success', 'Note deleted successfully.');
    }


    // Store category
    public function storeCategory(Request $request) //create new category
    {
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,' . Auth::id(),
            'color' => 'nullable|string|max:7'
        ]);

    Auth::user()->categories()->create($request->all()); //save the category for login user

        return redirect()->route('dashboard') //redirect to dashboard with success
            ->with('success', 'Category created successfully.');
    }
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if (!$token = auth()->attempt($request->only('email', 'password'))) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
    ]);
}
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Generate JWT token
    $token = JWTAuth::fromUser($user);

    return response()->json([
        'message' => 'Registration successful',
        'user' => $user,
        'token' => $token
    ]);
}


}





