<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;  // Use the Entry model
use App\Models\Category;

class EntryController extends Controller
{
    public function home()
    {
        // Fetch the top 3 most recent entries for the logged-in user
        $entries = Entry::where('user_id', auth()->id())->latest()->take(3)->get();

        // Return the view with the entries
        return view('home', compact('entries'));
    }

  
    // Show the page for starting to write a new entry
    public function showStartWriting()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('start-writing', compact('categories')); // Pass categories to the view
    }
    

    // Save the new entry to the database
    public function saveEntry(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:5',  // Body should be at least 5 characters long
        ]);

        // Create a new entry
        Entry::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),  // Associate the entry with the logged-in user
            'category_id' => $request->category_id,  // Optional: Handle the category if provided
        ]);

        // Redirect back to the home/dashboard or to view all entries
        return redirect()->route('view-all-thoughts')->with('message', 'Entry saved successfully!');
    }

    // Show all entries for the logged-in user
    public function viewAllEntries(Request $request)
    {
        $query = Entry::where('user_id', auth()->id());

        // If a category filter is applied
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // If a search filter is applied
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }

        $entries = $query->latest()->get();
        $categories = Category::where('user_id', auth()->id())->get();

        return view('view-all-thoughts', compact('entries', 'categories'));
    }


    // Show a single entry
    public function showEntry($id)
        {
            $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            return view('view-single-thought', compact('entry'));
        }

    // Show the form to edit an entry
    public function editEntry($id)
    {
        // Find the entry to edit
        $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Fetch category
        $categories = Category::where('user_id', auth()->id())->get();


        return view('edit-entry', compact('entry', 'categories')); // Pass both entry and categories to the view
    }


    // Save the updated entry
    public function updateEntry(Request $request, $id)
    {
        // Find the entry to update
        $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:5',
            'category_id' => 'nullable|exists:categories,id', // Validate category ID if provided
        ]);

        // Update the entry
        $entry->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,  // Update the category if selected
        ]);

        // Redirect to the view-all-thoughts page with a success message
        return redirect()->route('view-all-thoughts')->with('message', 'Entry updated successfully!');
    }
        public function deleteEntry($id)
        {
            // Find the entry by ID, make sure the logged-in user owns it
            $entry = Entry::where('user_id', auth()->id())->findOrFail($id);
        
            // Delete the entry
            $entry->delete();
        
            // Redirect back to view-all-thoughts with a success message
            return redirect()->route('view-all-thoughts')->with('message', 'Entry deleted successfully!');
        }
        
}
