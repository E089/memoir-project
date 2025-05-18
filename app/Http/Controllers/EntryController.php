<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;  
use App\Models\Category;
use App\Models\Tag;

class EntryController extends Controller
{
    public function home()
    {
        $entries = Entry::where('user_id', auth()->id())->latest()->take(3)->get();

        return view('home', compact('entries'));
    }

    public function showStartWriting()
    {
        $categories = Category::where('user_id', auth()->id())->get();
        return view('start-writing', compact('categories')); 
    }
    

    public function saveEntry(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:5',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string', 
        ]);
    
        $entry = Entry::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'favorite' => $request->boolean('favorite'), 
        ]);
    
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
    
        return redirect()->route('view-all-thoughts')->with('message', 'Entry saved successfully!');
    }

    public function viewAllEntries(Request $request)
    {
        $query = Entry::where('user_id', auth()->id());
    
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
    
        if ($request->has('tag') && $request->tag != '') {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }
        $entries = $query->with('tags')->latest()->get();
        $categories = Category::where('user_id', auth()->id())->get();
        $tags = Tag::where('user_id', auth()->id())->get(); 
    
        return view('view-all-thoughts', compact('entries', 'categories', 'tags'));
    }
    
    public function showEntry($id)
        {
            $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            return view('view-single-thought', compact('entry'));
        }

    public function editEntry($id)
    {
        $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    
        $categories = Category::where('user_id', auth()->id())->get();
    
        return view('edit-entry', compact('entry', 'categories'));
    }

    public function updateEntry(Request $request, $id)
    {
        $entry = Entry::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:5',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string', 
            'favorite' => 'nullable|boolean', 
        ]);

        $entry->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'favorite' => $request->has('favorite') ? $request->boolean('favorite') : false,
        ]);

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
            $entry = Entry::where('user_id', auth()->id())->findOrFail($id);
        
            $entry->delete();
        
            return redirect()->route('view-all-thoughts')->with('message', 'Entry deleted successfully!');
        }
        
}
