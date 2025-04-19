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
        return redirect()->route('home')->with('message', 'Entry saved successfully!');
    }

    // Show all entries for the logged-in user
    public function viewAllEntries()
    {
        $entries = Entry::where('user_id', auth()->id())->latest()->get();  // Get entries for the logged-in user

        return view('view-all-thoughts', compact('entries'));  // Pass entries to the view
    }
}
