<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new category and save it to the database
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect or respond as needed
        return redirect()->route('view-all-thoughts')->with('message', 'Category created successfully!');
    }
}
