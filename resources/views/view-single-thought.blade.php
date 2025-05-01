@extends('layouts.app')

@section('content')

<!-- Memoir Title OUTSIDE the container -->
<div class="navbar-center">memoir</div>

<!-- Entry content -->
<div class="single-entry-container position-relative">
    <a href="{{ url('/view-all-thoughts') }}" class="back-button absolute-top-left">
        <i class="fas fa-arrow-left"></i>
    </a>

    <h1 class="entry-title">{{ $entry->title }}</h1>

    <!-- Display tags if available -->
    @if($entry->tags)
        <div class="entry-tags">
            @foreach(explode(',', $entry->tags) as $tag)  <!-- Assuming tags are comma-separated -->
                @php
                    $tag = trim($tag);  // Remove any extra spaces
                    $tag = htmlspecialchars_decode($tag);  // Decode any HTML entities like &quot;
                    $tag = preg_replace('/[^a-zA-Z0-9 ]/', '', $tag); // Remove any unwanted symbols, e.g., quotes
                @endphp
                <span class="tag-badge">{{ $tag }}</span>  <!-- Only display cleaned tags -->
            @endforeach
        </div>
    @endif

    <p class="entry-body">{{ $entry->body }}</p>

    <!-- Edit Entry Button with Pen Icon inside a Box -->
    <a href="{{ route('entries.edit', $entry->id) }}" class="edit-button">
        <i class="fas fa-pencil-alt"></i>  <!-- Pen icon with box -->
    </a>
</div>

<style>
    body {
        position: relative;
    }
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

    .navbar-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 500;
        font-size: 1.5rem;
        font-family: 'Schoolbell', cursive;
        margin-top: 40px;
        z-index: 10;
    }

    .single-entry-container {
        max-width: 800px;
        background: #fffef5;
        padding: 4rem 3rem;
        border-radius: 14px;
        position: relative;
        border: 1px solid #e0e0e0;
        font-family: 'Schoolbell', cursive;
        margin: 5rem auto 2rem auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
        font-family: 'Schoolbell', cursive;
        color: #444;
        text-align: left;
    }

    .entry-tags {
        margin-top: 1rem;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .tag-badge {
        background-color: #ffde59;
        color: #333;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-family: 'Comic Neue', cursive;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .tag-badge:hover {
        background-color: #ffe873;
        cursor: pointer;
    }

    p {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #333;
        font-family: 'Fragment Mono', monospace;
        white-space: pre-wrap;
    }

    .absolute-top-left {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        font-size: 1.2rem;
        color: #444;
        text-decoration: none;
    }

    .absolute-top-left:hover {
        color: #222;
    }

    /* Edit Button Styling */
    .edit-button {
        position: absolute;  /* Absolute positioning */
        top: 1rem;  /* Top distance */
        right: 1rem;  /* Right distance */
        background-color: transparent;
        padding: 5px 10px;  /* Padding for a neat box */
        border-radius: 12px;
        font-size: 0.5rem;  /* Icon size */
        color: #444;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .edit-button:hover {
        background-color: #ffde59;  /* Background change on hover */
        color: #222;
        border-color: #ffe873;  /* Lighter border color */
    }

    .edit-button i {
        font-size: 1.8rem;  /* Adjust icon size */
    }
</style>

@endsection
