@extends('layouts.app')

@section('content')
<div class="edit-entry-container">
    <h1>Edit Your Entry</h1>

    <form action="{{ route('entries.update', $entry->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Update method, should be PUT for edit -->

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ $entry->title }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" id="body" class="form-control" required>{{ $entry->body }}</textarea>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category_id" id="category" class="form-control">
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ $category->id == $entry->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="submit-button">Update Entry</button>
    </form>
</div>

<style>
    .edit-entry-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 2rem;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    label {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    input, textarea, select {
        width: 100%;
        padding: 0.8rem;
        font-size: 1rem;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    textarea {
        min-height: 150px;
    }

    .submit-button {
        background-color: black;
        color: white;
        font-size: 1.2rem;
        padding: 0.8rem 2rem;
        border: none;
        border-radius: 25px;
        margin-top: 20px;
        cursor: pointer;
        width: 100%;
    }

    .submit-button:hover {
        background-color: #333;
    }
</style>
@endsection
