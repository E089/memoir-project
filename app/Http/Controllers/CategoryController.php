<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new category with the logged-in user's ID
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(), // Associate category with current user
        ]);

        // Redirect or respond as needed
        return redirect()->route('view-all-thoughts')->with('message', 'Category created successfully!');
    }

    public function destroy($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);
    
        // Delete the category
        $category->delete();
    
        // Redirect back with a success message
        return redirect()->route('view-all-thoughts')->with('success', 'Category deleted successfully!');
    }
    

}
