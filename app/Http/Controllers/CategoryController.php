<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    //Loads user's categories and note count
    //checks if user entered search ,if yes searches all notes, returns paginated
    //sends categories, search and notes to the view
public function index(Request $request)
{
$search = $request->input('search');

    $categories = Auth::user()->categories()->withCount('notes')->get();

    $notes = collect(); // default empty

    if ($search) {
        // Search notes across all categories
        $notes = Auth::user()->notes()
            ->where('title', 'like', '%' . $search . '%')
            ->orWhere('content', 'like', '%' . $search . '%') 
            ->latest()
            ->paginate(10);
    }

 return view('dashboard', compact('categories', 'search', 'notes'));
}



public function showNotes(Category $category, Request $request)
{
    // authorization check 
    if ($category->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    
    $search = $request->input('search'); 
    
    $notes = $category->notes() //if search exists, filters notes inside category
        ->when($search, function($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(10);
    
    $categories = Auth::user()->categories()->get();
    
    return view('categories.notes', compact('category', 'notes', 'categories', 'search'));//passes categories,notes,search in categories.notes view
}

    //shows form for create new category
    public function create()
    {
        return view('categories.create');
    }

    //stores new category, validayes input, creates new category for logged in user, redirects dashboard with success massege
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,' . Auth::id(),
            'color' => 'required|string|max:7'
        ]);

        Auth::user()->categories()->create($request->all());

        return redirect()->route('dashboard')
            ->with('success', 'Category created successfully.');
    }

    
 public function edit(Category $category)
    {
        //authorization check
         if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('categories.edit', compact('category')); //shows edit form with category data
    }
public function update(Request $request, Category $category)
    {
        //  authorization check
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([     //validates name except current category
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . ',id,user_id,' . Auth::id(),
            'color' => 'required|string|max:7'
        ]);

    $category->update($request->all());

        return redirect()->route('dashboard')
            ->with('success', 'Category updated successfully.');
    }

    //
public function destroy(Category $category)
    {
        //  authorization check
            if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $category->delete();  //deletes category

        return redirect()->route('dashboard')
            ->with('success', 'Category deleted successfully.');
    }
}