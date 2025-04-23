@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Your Thoughts</h2>

    <!-- Filter and Search -->
    <div class="d-flex justify-content-between mb-4">
        <!-- Category Filter Dropdown -->
        <form action="{{ route('view-all-thoughts') }}" method="GET" class="d-flex align-items-center">
            <label for="category" class="mr-2">Category:</label>
            <select name="category" id="category" class="form-control mr-2">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>
        </form>

        <!-- Search Bar -->
        <form action="{{ route('view-all-thoughts') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search thoughts..." value="{{ request()->search }}">
            <button type="submit" class="btn btn-primary ml-2">
                <i class="fas fa-search"></i> Search
            </button>
        </form>

        <!-- Add Category Button -->
        <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#categoryModal">
            <i class="fas fa-plus"></i> Add Category
        </button>

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
        <div class="list-group">
            @foreach ($entries as $entry)
                <div class="d-flex justify-content-between mb-3">
                    <!-- Entry Box (Clickable) -->
                    <a href="{{ route('entries.show', $entry->id) }}" class="list-group-item list-group-item-action flex-column align-items-start w-100">
                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <h5 class="mb-1">{{ $entry->title }}</h5>
                                <p class="mb-1">{{ Str::limit($entry->body, 100) }}</p>
                            </div>
                            <!-- Date on the right -->
                            <div>
                                <small>{{ $entry->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Delete Button Outside the Box -->
                    <form action="{{ route('delete-entry', $entry->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" title="Delete Entry">
                            <i class="fas fa-trash"></i> <!-- Font Awesome trash icon -->
                        </button>
                    </form>
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
    </style>
@endsection
