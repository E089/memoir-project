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

    <!-- Tags Section -->
    <div class="tags-container">
        @php
            $visibleTags = array_slice($entry->tags->toArray(), 0, 3);  // Display only first 8 tags
            $hiddenTags = array_slice($entry->tags->toArray(), 3);      // Remaining tags to be shown on 'See More'
        @endphp

        @foreach ($entry->tags as $index => $tag)
            <div class="tag {{ $index >= 3 ? 'hidden-tag' : '' }}">
                <span title="{{ $tag->name }}">{{ \Illuminate\Support\Str::limit($tag->name, 10) }}</span>
            </div>
        @endforeach
        <!-- See More Button -->
        @if (count($hiddenTags) > 0)
            <button class="see-more-btn">See More</button>
        @endif
    </div>
    <!-- Scrollable wrapper for entry body -->
    <div class="entry-body-wrapper">
        <div class="entry-body">{!! $entry->body !!}</div>
    </div>



    <!-- Edit Entry Button with Pen Icon inside a Box -->
    <a href="{{ route('entries.edit', $entry->id) }}" class="edit-button">
        <i class="fas fa-pencil-alt"></i>  <!-- Pen icon with box -->
    </a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const seeMoreButton = document.querySelector(".see-more-btn");
        const hiddenTags = document.querySelectorAll(".hidden-tag");

        if (seeMoreButton) {
            seeMoreButton.addEventListener("click", function() {
                hiddenTags.forEach(tag => {
                    tag.classList.toggle("show");
                });

                seeMoreButton.textContent = seeMoreButton.textContent === "See More" ? "See Less" : "See More";
            });
        }
    });
</script>



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

    .tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 1rem;
    margin-bottom: 2rem;
    justify-content: left;
    }

    .tag {
        background-color: #ffde59;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 1rem;
        color: #333;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.3s;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .tag:hover {
        background-color: #ffe873;
        transform: translateY(-2px);
    }

    .tag i {
        margin-left: 5px;
        font-size: 1.2rem;
    }

    .entry-title {
    white-space: nowrap; /* Prevent the title from wrapping to the next line */
    overflow: hidden; /* Hide the overflowed content */
    text-overflow: ellipsis; /* Add ellipsis when the text overflows */
    max-width: 100%; /* Ensure the title fits within its container */
    }

    .see-more-btn {
        background-color: transparent;
        border: 1px solid #ffde59;
        color: #ffde59;
        padding: 8px 12px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 10px;
        font-family: 'Schoolbell', cursive;
        transition: background-color 0.3s;
    }

    .see-more-btn:hover {
        background-color: #ffde59;
        color: white;
    }

    .hidden-tag {
    display: none;
    }

    .hidden-tag.show {
    display: inline-flex;
    }

    .entry-body {
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    max-width: 100%;
    overflow-x: auto;
    padding: 1rem 0;
    line-height: 1.6;
}

.entry-body h1, 
.entry-body h2, 
.entry-body h3 {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

.entry-body p {
    margin-bottom: 1rem;
}

.entry-body ul,
.entry-body ol {
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}

.entry-body-wrapper {
    max-height: 400px; /* or any height you prefer */
    overflow-y: auto;
    padding-right: 0.5rem;
    margin-top: 1rem;
    border: 1px dashed #e0e0e0;
    background-color: #fffefc;
    border-radius: 8px;
}



</style>

@endsection
