@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: auto;
        min-height: 100%;
        margin: 0;
        padding: 0;
        background: url('{{ asset('writing.png') }}');
        background-position: center;
        background-repeat: no-repeat;
        background-size: 1950px;
        overflow-x: hidden;
    }
    .writing-container {
        max-width: 900px;
        margin: 4rem auto;
        background: #fffef5;
        padding: 4rem 3rem;
        border-radius: 14px;
        position: relative;
        border: 1px solid #e0e0e0;
    }

    .save-button {
        position: absolute;
        top: 25px;
        right: 25px;
        background-color: #ffde59;
        border: none;
        color: #000;
        font-size: 1rem;
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        font-family: 'Comic Neue', cursive;
    }

    .save-button:hover {
        background-color: #ffe873;
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

    .back-button i {
        margin-right: 6px;
        font-size: 1.2rem;
    }

    .back-button:hover {
        color: #000;
        text-decoration: none;
    }

    .writing-container input[type="text"],
    .writing-container textarea,
    .writing-container select {
        width: 100%;
        border: none;
        border-bottom: 1px solid #bbb;
        padding: 1rem 0;
        margin-bottom: 2rem;
        font-size: 1.15rem;
        background: transparent;
        outline: none;
        font-family: 'Segoe UI', sans-serif;
    }

    .writing-container textarea {
        height: 350px;
        resize: vertical;
    }

    .form-group label {
        display: none;
    }

    .entry-heading {
        text-align: center;
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 2.5rem;
        font-family: 'Segoe UI', sans-serif;
    }
</style>

<div class="writing-container">
    <!-- 🡐 Back Button -->
    <a href="{{ url('/home') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> 
    </a>

    <div class="entry-heading">Start Writing</div>

    <form method="POST" action="{{ url('/start-writing') }}">
        @csrf

        <input type="text" id="title" name="title" placeholder="Title..." required>

        <textarea id="body" name="body" placeholder="Write your thoughts here..." required></textarea>

        <select id="category_id" name="category_id">
            <option value="">Select a Category (Optional)</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="save-button">Save</button>
    </form>
</div>
@endsection
