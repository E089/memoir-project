@extends('layouts.app')

@section('content')

<!-- Navbar with Back Button -->
<div class="navbar fixed-top">
    <div class="navbar-left">
        <!-- 🡐 Back Button -->
        <a href="{{ url('/home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> 
        </a>
    </div>
    <div class="navbar-center">memoir</div>
</div>

<div class="fixed-top py-3" style="z-index: 1030; padding-top: 50px;">
    <div class="container">
        <h2 class="mb-3" style="margin-top: 90px; font-size: 50px;">Wall of Thoughts</h2> <!-- Adjusted the margin-top -->
        <div class="row g-3 align-items-end">
            <!-- Category Filter -->
            <div class="col-md-5">
                <form action="{{ route('view-all-thoughts') }}" method="GET" class="d-flex">
                    <select name="category" id="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-filter"></i>
                    </button>
                </form>
            </div>

            <!-- Search Bar -->
            <div class="col-md-5">
                <form action="{{ route('view-all-thoughts') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Search thoughts..." value="{{ request()->search }}">
                    <button type="submit" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Add Category Button -->
            <div class="col-md-2 text-md-end text-start">
                <button class="btn btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container" style="margin-top: 160px;">
   <!-- Category Creation Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Create New Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm" method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" id="categoryName" class="form-control" name="name" required>
                        </div>
                        <button type="submit" class="submit-button">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- Thought Entries -->
    @if($entries->count())
        <div class="row mt-4">
            @foreach ($entries as $entry)
                <div class="col-md-4 mb-4">
                    <div class="card sticky-note" style="transform: rotate({{ rand(-4, 4) }}deg);">
                        <div class="card-body d-flex flex-column justify-content-between h-100">
                            <a href="{{ route('entries.show', $entry->id) }}" class="text-dark text-decoration-none">
                                <h5 class="card-title">{{ $entry->title }}</h5>
                                <p class="card-text">{{ Str::limit($entry->body, 100) }}</p>
                            </a>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">{{ $entry->created_at->format('M d, Y') }}</small>
                                <form action="{{ route('delete-entry', $entry->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Delete Entry">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mt-4">
            You haven't written any entries yet. Start writing your first thought!
        </div>
    @endif
</div>

@endsection

@section('styles')
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Schoolbell&family=Fragment+Mono&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Fragment Mono', monospace;
    }

    h1, h2, h3, .card-title {
        font-family: 'Schoolbell', cursive;
    }

    .card-text, p, small, select, input, textarea {
        font-family: 'Fragment Mono', monospace;
    }

    .btn-delete {
        background: none;
        border: none;
        color: black;
        cursor: pointer;
        font-size: 18px;
        margin-top: 10px;
    }

    .btn-delete:hover {
        color: black;
    }

    .form-control {
        max-width: 250px;
    }

    .card.sticky-note {
        background-color: #FFDB4C;
        border: none;
        border-radius: 0px;
        min-height: 340px;
        padding: 20px;
        transition: transform 0.2s ease-in-out;
        font-family: 'Schoolbell', cursive;
        position: relative;
    }

    .card.sticky-note:hover {
        transform: scale(1.03);
    }

    .navbar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1040;
        padding: 10px 20px;

    }

    .navbar-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 500;
        font-size: 1.5rem;
        font-family: 'Schoolbell', cursive;
        margin-top: 70px; /* Adjust gap between navbar and memoir */
    }

    .navbar-left {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
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

     /* Modal Styling */
    .modal-content {
        background-color: #ffffff; /* White background */
        border-radius: 12px;
        border: none; /* Remove border */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid #eee; /* Light border to separate header */
        background-color: #f7f7f7; /* Light pastel gray */
        padding: 1.5rem;
        position: relative;
    }

    .modal-title {
        font-size: 1.5rem;
        font-family: 'Schoolbell', cursive;
        color: #333;
    }

    .close {
        color: #aaa;
        font-size: 1.5rem;
        position: absolute;
        top: 15px;
        right: 20px;
        background: none;
        border: none;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body label {
        font-weight: 600;
        font-size: 1rem;
        color: #555;
    }

    .modal-body input,
    .modal-body textarea {
        width: calc(100% - 40px); /* Adjust width to leave space for the button */
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.8rem;
        background-color: #f9f9f9;
        font-size: 1rem;
        margin-top: 0.5rem;
        margin-right: 40px; /* Add some space for the button */
    }

    .modal-body textarea {
        resize: vertical;
        min-height: 80px;
    }

    .modal-body button {
        border-radius: 50%;
        background-color: transparent;
        color: #ffde59; /* Soft pastel yellow */
        border: none;
        font-size: 1.5rem;
        padding: 0.5rem;
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        transition: none; /* Remove hover effect */
        outline: none; /* Remove the blue outline */
    }

    /* Remove blue border when clicking the check button */
    .modal-body button:focus {
        outline: none; /* Ensure no blue border when clicked */
    }

    /* Ensure modal body stretches input fields */
    .modal-body .form-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Remove yellow circle around the check icon */
    .modal-body button i {
        margin: 0;
        font-size: 1.2rem;
    }

    /* Optional: Enhance the button's position */
    .modal-body .form-group button {
        position: relative;
        top: 5px;
    }

    .submit-button {
    background-color: transparent;
    border: none;
    color: #ffde59;
    font-size: 1.5rem;
    padding: 0.5rem;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    outline: none;
    }

    .submit-button:focus {
        outline: none;
        box-shadow: none;
    }

    .submit-button i {
        margin: 0;
        font-size: 1.2rem;
    }
</style>
@endsection
	