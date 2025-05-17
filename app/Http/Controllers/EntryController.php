<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;  // Use the Entry model
use App\Models\Category;
use App\Models\Tag;

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
    

    public function saveEntry(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:5',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string', // JSON string of tag names
        ]);
    
        // Create the entry
        $entry = Entry::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'favorite' => $request->boolean('favorite'), // 👈 Add this line
        ]);
    
        // Handle tags
        if ($request->filled('tags')) {
            $tagNames = json_decode($request->tags, true);
            $tagIds = [];
        
            foreach ($tagNames as $name) {
                $trimmed = trim($name);
                if ($trimmed === '') continue;
        
                // Ensure user_id is passed when creating the tag
                $tag = Tag::firstOrCreate(['name' => $trimmed, 'user_id' => auth()->id()]);
                $tagIds[] = $tag->id;
            }
        
            $entry->tags()->sync($tagIds);
        }
    
        return redirect()->route('view-all-thoughts')->with('message', 'Entry saved successfully!');
    }

    public function viewAllEntries(Request $request)
    {
        $query = Entry::where('user_id', auth()->id());
    
        // If a category filter is applied
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
    
        // If a tag filter is applied
        if ($request->has('tag') && $request->tag != '') {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }
    
        // If a search filter is applied
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }
    
        // Eager load tags
        $entries = $query->with('tags')->latest()->get();
    
        // Get categories and tags for filtering
        $categories = Category::where('user_id', auth()->id())->get();
        $tags = Tag::where('user_id', auth()->id())->get(); // Retrieve tags for filter
    
        return view('view-all-thoughts', compact('entries', 'categories', 'tags'));
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
    
        // Fetch categories
        $categories = Category::where('user_id', auth()->id())->get();
    
        return view('edit-entry', compact('entry', 'categories'));
    }

    // Save the updated entry
    public function updateEntry(Request $request, $id)
    {
        $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:5',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string', // Should be a JSON string of tag names
            'favorite' => 'nullable|boolean', // Validate favorite
        ]);

        // Update the entry
        $entry->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'favorite' => $request->has('favorite') ? $request->boolean('favorite') : false,
        ]);

        // Check if tags are passed and update association
        if ($request->filled('tags')) {
            $tagNames = json_decode($request->tags, true);
            $tagIds = [];

            foreach ($tagNames as $name) {
                $trimmed = trim($name);
                if ($trimmed === '') continue;

                $tag = Tag::firstOrCreate(['name' => $trimmed, 'user_id' => auth()->id()]);
                $tagIds[] = $tag->id;
            }

            $entry->tags()->sync($tagIds);
        }

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
