@extends('layouts.app')

@section('content')
<style>
    .edit-entry-container {
        max-width: 700px;
        margin: 3rem auto;
        background: #fffef5;
        padding: 3rem 2rem;
        border-radius: 12px;
        position: relative;
        border: 1px solid #e0e0e0;
    }

    .save-button {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #ffde59;
        border: none;
        color: #000;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        font-family: 'Comic Neue', cursive;
    }

    .save-button:hover {
        background-color: #ffe873;
    }

    .edit-entry-container input[type="text"],
    .edit-entry-container textarea,
    .edit-entry-container select {
        width: 100%;
        border: none;
        border-bottom: 1px solid #bbb;
        padding: 0.8rem 0;
        margin-bottom: 2rem;
        font-size: 1.1rem;
        background: transparent;
        outline: none;
        font-family: 'Segoe UI', sans-serif;
    }

    .edit-entry-container textarea {
        height: 250px;
        resize: vertical;
    }

    .form-group label {
        display: none;
    }

    h1 {
        font-size: 1.8rem;
        text-align: center;
        margin-bottom: 2rem;
        color: #444;
    }

    .back-button {
        position: absolute;
        top: 25px;
        left: 25px;
        background: none;
        border: none;
        color: #555;
        font-size: 1rem;
        font-family: 'Segoe UI', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        text-decoration: none;
    }
</style>

<!-- Navigation bar -->
<div class="navbar">
    <div class="navbar-left"></div>
    <div class="navbar-center">memoir</div>
    <div class="navbar-right">
        <a href="#">home.</a>
        <a href="#">about.</a>
        <a href="#">contact us.</a>
    </div>
</div>

<div class="edit-entry-container">
     <!-- 🡐 Back Button -->
     <a href="{{ url('/view-all-thoughts') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> 
    </a>

    <h1>Edit Your Entry</h1>
    <form action="{{ route('entries.update', $entry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="title" id="title" value="{{ $entry->title }}" placeholder="Edit your title..." required>

        <textarea name="body" id="body" placeholder="Edit your thoughts here..." required>{{ $entry->body }}</textarea>

        <select name="category_id" id="category">
            <option value="">Select a Category (Optional)</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $entry->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="save-button">Update Entry</button>
    </form>
</div>
@endsection
