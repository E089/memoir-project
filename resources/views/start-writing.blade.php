@extends('layouts.app')

@section('content')
<style>
    .writing-container {
        max-width: 800px;
        margin: 3rem auto;
        background: #fff;
        padding: 2rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .writing-container h2 {
        text-align: center;
        margin-bottom: 2rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: bold;
        color: #555;
        display: block;
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }

    .form-group textarea {
        height: 300px;
        resize: vertical;
    }

    .submit-button {
        background-color: black;
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 25px;
        font-size: 1.2rem;
        cursor: pointer;
        display: block;
        margin: 2rem auto 0;
        transition: background-color 0.3s ease;
    }

    .submit-button:hover {
        background-color: #333;
    }
</style>

<div class="writing-container">
    <h2>Start Writing</h2>

    <form method="POST" action="{{ url('/start-writing') }}">
        @csrf <!-- CSRF token for security -->

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="body">Your Thoughts</label>
            <textarea id="body" name="body" required></textarea>
        </div>

        <button type="submit" class="submit-button">Save Entry</button>
    </form>
</div>

@endsection
