<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('view-all-thoughts')->with('message', 'Category created successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    
        $category->delete();
    
        return redirect()->route('view-all-thoughts')->with('success', 'Category deleted successfully!');
    }
    

}
