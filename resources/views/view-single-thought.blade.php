@extends('layouts.app')

@section('content')
<div class="single-entry-container">
    <h1>{{ $entry->title }}</h1>
    <p>{{ $entry->body }}</p>

    <a href="{{ route('entries.edit', $entry->id) }}" class="edit-button">
        ✏️ Edit Entry
    </a>
</div>

<style>
    .single-entry-container {
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

    p {
        font-size: 1.2rem;
        line-height: 1.6;
        color: #333;
    }

    .edit-button {
        display: inline-block;
        background-color: black;
        color: white;
        font-size: 1.1rem;
        padding: 0.5rem 1.5rem;
        text-decoration: none;
        border-radius: 20px;
        margin-top: 20px;
        text-align: center;
    }

    .edit-button:hover {
        background-color: #333;
    }
</style>
@endsection
