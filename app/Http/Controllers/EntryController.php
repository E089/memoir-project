<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;  // Use the Entry model

class EntryController extends Controller
{
    // Show the page for starting to write a new entry
    public function showStartWriting()
    {
        return view('start-writing');  // View for starting a new entry
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
    public function viewAllEntries()
    {
        $entries = Entry::where('user_id', auth()->id())->latest()->get();  // Get entries for the logged-in user

        return view('view-all-thoughts', compact('entries'));  // Pass entries to the view
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
            $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            return view('edit-entry', compact('entry'));
        }

    // Save the updated entry
    public function updateEntry(Request $request, $id)
        {
            $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

            $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string|min:5',
            ]);

            $entry->update([
                'title' => $request->title,
                'body' => $request->body,
            ]);

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
