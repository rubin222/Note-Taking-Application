<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    //
    public function store(Request $request, Category $category)
    {
        //  authorization check
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.'); //if not quthorixwd, i gives 403 Unauthorized error
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $category->notes()->create([  //creates new note 
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('categories.notes', $category)  //redirects back to notes list auth/categories/notes
            ->with('success', 'Note created successfully.');
    }

    //
public function update(Request $request, Note $note)
    {
        //  authorization check
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($request->all());   //update note with new title and content

        return redirect()->route('categories.notes', $note->category) //redirects to category's note page
            ->with('success', 'Note updated successfully.');
    }

    //
    public function destroy(Note $note)
    {
        //  authorization check
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
    $category = $note->category;  //stores category before deleting and deletes from database
        $note->delete();

        return redirect()->route('categories.notes', $category) //redirects to categories/notes
            ->with('success', 'Note deleted successfully.');
    }
    
}