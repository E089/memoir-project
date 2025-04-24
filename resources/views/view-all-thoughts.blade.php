@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Your Thoughts</h2>

   <!-- Filter, Search, and Add Category -->
<div class="mb-4">
    <div class="row g-3 align-items-end">
        <!-- Category Filter -->
        <div class="col-md-5">
            <form action="{{ route('view-all-thoughts') }}" method="GET" class="d-flex">
                <select name="category" id="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline-primary ml-2">
                    <i class="fas fa-filter"></i>
                </button>
            </form>
        </div>


        <!-- Search Bar -->
        <div class="col-md-5">
            <form action="{{ route('view-all-thoughts') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Search thoughts..." value="{{ request()->search }}">
                <button type="submit" class="btn btn-outline-primary ml-2">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Add Category Button -->
        <div class="col-md-2 text-md-right text-left">
            <button class="btn btn-primary w-100 w-md-auto" data-toggle="modal" data-target="#categoryModal">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>
    </div>
</div>



    <!-- Category Creation Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Create New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add action to the form and ensure it uses POST -->
                    <form id="categoryForm" method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" id="categoryName" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryDescription">Description</label>
                            <textarea id="categoryDescription" class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- If there are entries -->
        @if($entries->count())
        <div class="row">
            @foreach ($entries as $entry)
                <div class="col-md-4 mb-4">
                    <div class="card sticky-note">
                        <div class="card-body">
                            <a href="{{ route('entries.show', $entry->id) }}" class="text-dark text-decoration-none">
                                <h5 class="card-title">{{ $entry->title }}</h5>
                                <p class="card-text">{{ Str::limit($entry->body, 100) }}</p>
                            </a>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">{{ $entry->created_at->format('M d, Y') }}</small>
                                <form action="{{ route('delete-entry', $entry->id) }}" method="POST" style="margin: 0;">
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
        <div class="alert alert-info">
            You haven't written any entries yet. Start writing your first thought!
        </div>
    @endif


</div>

@endsection

<!-- Add some style for the delete button -->
@section('styles')
    <style>
        .btn-delete {
            background: none;
            border: none;
            color: red;
            cursor: pointer;
            font-size: 18px;
            margin-top: 10px;
        }

        .btn-delete:hover {
            color: darkred;
        }

        .fas.fa-trash {
            margin-right: 5px;
        }

        .form-control {
            max-width: 250px;
        }

        /* This is the winning combo */
        .card.sticky-note {
            background-color: #fff89a !important; /* Sticky note yellow */
            border-radius: 10px;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.15);
            transition: transform 0.2s ease;
            min-height: 200px;
        }

        .card.sticky-note:hover {
            transform: scale(1.02);
        }

        .btn-yellow {
        background-color: #fdd835;
        color: #000;
        border: none;
        }

        .btn-yellow:hover {
            background-color: #fbc02d;
            color: #000;
        }
    </style>
@endsection

