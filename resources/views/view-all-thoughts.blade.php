@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Schoolbell&family=Inter:wght@300;400;600&display=swap');

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
        font-family: 'Fragment Mono', monospace;
    }

    h1, h2, h3, .card-title {
        font-family: 'Schoolbell', cursive;
        font-size: 2rem;
        margin-top: px;
        
    }

    .card-text, p, select, input, textarea {
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
    font-family: 'Schoolbell', cursive;
    position: relative;
    transition: transform 0.6s ease-in-out;
    }

    .card.sticky-note:hover {
        animation: pop 0.6s ease;
    }

    @keyframes pop {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
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
        margin-top: 70px; 
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

    .modal-content {
        background-color: #ffffff; 
        border-radius: 12px;
        border: none; 
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid #eee; 
        background-color: #f7f7f7; 
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
        width: calc(100% - 40px); 
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.8rem;
        background-color: #f9f9f9;
        font-size: 1rem;
        margin-top: 0.5rem;
        margin-right: 40px; 
    }

    .modal-body textarea {
        resize: vertical;
        min-height: 80px;
    }

    .modal-body button {
        border-radius: 50%;
        background-color: transparent;
        color: #ffde59; 
        border: none;
        font-size: 1.5rem;
        padding: 0.5rem;
        cursor: pointer;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        transition: none; 
        outline: none; 
    }

    .modal-body button:focus {
        outline: none; 
    }

    .modal-body .form-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body button i {
        margin: 0;
        font-size: 1.2rem;
    }

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

    .wall-title {
    margin-bottom: 2.5rem; 
    }

    .add-category-btn {
        background-color: transparent;
        border: 1px solid #333;
        color: #333;
        font-size: 1.2rem; 
        padding:  0.5rem 1rem; 
        width: auto;
        text-decoration: none;
        border-radius: 30px; 
        transition: background-color 0.3s ease;
        text-align: center;
        font-family: 'Schoolbell', cursive;
        }

    .add-category-btn:hover {
        background-color: black; 
        color: white;
        border-color: black; 
    }

    .scrollable-wall {
    max-height: 60vh;
    max-width:150rem;
    overflow-y: AUTO;
    border-top:hidden;
    }

    .card-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%; 
    display: block;
    font-size: 1.5rem; 
    }

    .tag-style {
    background: transparent;
    border: 1px solid black;
    color: black;
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 0.8rem;
    font-family: 'Schoolbell', cursive;
    margin-right: 4px;
    max-width: 70px; 
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: inline-block;
    vertical-align: middle;
    }

    .text-truncate-multiline {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.5em;
    max-height: 4.5em; 
    }

    form input.form-control {
    border: 1.5px solid black;
    background-color: transparent   ;
    font-family: 'Fragment Mono', monospace;
    height: 40px;
}

</style>

<div class="navbar fixed-top">
    <div class="navbar-left">
        <a href="{{ url('/home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> 
        </a>
    </div>
    <div class="navbar-center">memoir</div>
</div>

<div class="pt-0 fixed-top" style="margin-top: 5rem;">
    <div class="container">
        <h2 class="wall-title text-center">Wall of Thoughts</h2>
        <div class="row g-3 align-items-center justify-content-center text-center">
            <div class="col-md-6">
                <form action="{{ route('view-all-thoughts') }}" method="GET" class="w-100 position-relative">
                    <input type="text" name="search" class="form-control ps-5 rounded-pill" placeholder="Search thoughts..." value="{{ request()->search }}" >
                    <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                </form>
            </div>

            <div class="col-md-3">

                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle custom-btn w-100" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 30px; margin-left:-800px;">
                        <span>
                            @if(request()->has('category'))
                                {{ $categories->find(request()->category)->name ?? 'Filter by Category' }}
                            @else
                                Filter by Category
                            @endif
                        </span>
                    </button>
                    <ul class="dropdown-menu w-100 text-center" aria-labelledby="categoryDropdown" style="border-radius: 30px; max-height: 250px; overflow-y: auto;">
                        <li>
                            <a class="dropdown-item" href="{{ route('view-all-thoughts') }}">All Categories</a>
                        </li>
                        @foreach ($categories->unique('name') as $category)
                            <li>
                                <div class="d-flex align-items-center justify-content-between px-3">
                                    <a href="{{ route('view-all-thoughts', ['category' => $category->id]) }}" class="text-truncate text-start text-dark text-decoration-none flex-grow-1">
                                        {{ $category->name }}
                                    </a>
                               <form action="{{ route('delete-category', $category->id) }}" method="POST" class="delete-category-form ms-2">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-link text-danger p-0 delete-category-btn" title="Delete Category">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

            <div class="col-md-3" style="margin-left:-25.5rem;">
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle custom-btn w-100" type="button" id="tagDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 30px;">
                        <span>
                            @if(request()->has('tag'))
                                {{ $tags->find(request()->tag)->name ?? 'Filter by Tag' }}
                            @else
                                Filter by Tag
                            @endif
                        </span>

                        
                    </button>
                    <ul class="dropdown-menu w-100 text-center" aria-labelledby="tagDropdown" style="border-radius: 30px; max-height: 250px; overflow-y: auto;">
                        <li><a class="dropdown-item" href="{{ route('view-all-thoughts') }}">All Tags</a></li>
                        @foreach ($tags as $tag)
                            <li><a class="dropdown-item text-truncate" href="{{ route('view-all-thoughts', ['tag' => $tag->id]) }}">{{ $tag->name }}</a>
                             </li>
                        @endforeach

                        
                    </ul>

                
                </div>
            </div>
            <div class="col-md-3">
                <button class="btn custom-btn w-100 add-category-btn" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
        </div>
    </div>
</div>
<div class="container" style="margin-top: 100px;">
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
<div class="container mt-4" > <div class="p-2">
        <div class="scrollable-wall row"style="max-widgth:50rem;"> 
            @foreach ($entries as $entry)
                <div class="col-md-4 mb-4">
                    <div class="card sticky-note" style="transform: rotate({{ rand(-4, 4) }}deg);">
                        <div class="card-body d-flex flex-column justify-content-between h-100">
                            <a href="{{ route('entries.show', $entry->id) }}" class="text-dark text-decoration-none">
                                <h5 class="card-title d-flex justify-content-between align-items-center">
                                    <span>{{ $entry->title }}</span>
                                    @if ($entry->favorite)
                                        <i class="fas fa-heart text-danger" title="Favorite"></i>
                                    @endif
                                </h5>

                                @if ($entry->tags->count())
                                    <div class="mb-2">
                                    @if ($entry->tags->count())
                                        <div class="mb-2">
                                        @php
                                            $visibleTags = $entry->tags->take(3);
                                            $remainingCount = $entry->tags->count() - $visibleTags->count();
                                        @endphp

                                        @foreach ($visibleTags as $tag)
                                            <span class="tag-style" title="{{ $tag->name }}">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach

                                        @if ($remainingCount > 0)
                                            <span class="tag-style">+{{ $remainingCount }} more</span>
                                        @endif
                                        </div>
                                    @endif
                                    </div>
                                @endif
                                <div class="card-text text-truncate-multiline">
                                    {!! $entry->body !!}
                                </div>
                            </a>
                           <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">{{ $entry->created_at->format('M d, Y h:i A') }}</small>

                                <form action="{{ route('delete-entry', $entry->id) }}" method="POST" class="m-0 delete-entry-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete show-confirm" title="Delete Entry">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($entries->isEmpty())
        <div class="alert alert-info mt-4">
            You haven't written any entries yet. Start writing your first thought!
        </div>
    @endif

    <div class="text-center mt-4 text-muted small">
        &copy; 2025 Memoir
    </div>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.show-confirm').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This entry will be lost forever 🥺",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>


@endsection
	