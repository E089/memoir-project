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
    <p class="entry-body">{{ $entry->body }}</p>

    <a href="{{ route('entries.edit', $entry->id) }}" class="edit-button">
        Edit Entry
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
        margin-bottom: 1.5rem;
        font-family: 'Schoolbell', cursive;
        color: #444;
        text-align: left;
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

    .entry-title {
        font-size: 1.8rem;
        font-weight: 600;
        border-bottom: 1px solid #ccc;
        padding-bottom: 0.5rem;
        color: #222;
        margin-top: 0.5rem;
        margin-left: 2.5rem;
    }

    .entry-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #444;
    white-space: pre-wrap;
    margin-top: 1.5rem;
    margin-left: 2.5rem;
    margin-right: 1rem;
    max-height: 400px; /* You can adjust this height */
    overflow-y: auto; /* Adds vertical scroll if the content overflows */
    padding-right: 10px; /* Optional: Adds some padding to the right for scroll */
    }


    .edit-button {
        display: inline-block;
        background-color: #ffde59;
        color: #000;
        font-size: 0.95rem;
        padding: 0.4rem 1rem;
        text-decoration: none;
        border-radius: 12px;
        margin-top: 2rem;
        margin-left: 2.5rem;
        font-family: 'Comic Neue', cursive;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.08);
    }

    .edit-button:hover {
        background-color: #ffe873;
    }
</style>
@endsection
