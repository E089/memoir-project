@extends('layouts.app')

@section('content')

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
        margin-top: 5px;
        z-index: 10;
    }

        .back-button {
        position: absolute;
        top: -10px;
        left: -20px;
        background:rgb(223, 62, 33);
        border: none;
        color: #555;
        font-size: 1.2rem;
        font-family: 'Schoolbell', cursive;
        cursor: pointer;
        padding: 0.6rem 1.2rem;
        border-radius: 50%;
        box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        transform: rotate(-15deg);
        transition: transform 0.2s;
    }

    .back-button i {
        margin-right: 6px;
        font-size: 1.2rem;
        
        
    }

    .back-button:hover {
        color: #000;
        text-decoration: none;
        transform: rotate(0deg);
    }

    .single-entry-container {
        height: 600px;
        max-width: 1000px;
        margin: 2rem auto;
        background: #FFDB4C;
        padding: 4rem 3rem;
        position: relative;
        font-family: 'Schoolbell', cursive;
        box-shadow: 20px 20px 3px rgba(0, 0, 0, 0.2);
        height: 750px;
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
        background-color:transparent;
        color: #333;
        padding: 5px 10px;
        border-color:black;
        border-radius: 20px;
        font-size: 0.9rem;
        font-family: 'Schoolbell', cursive;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);

    }

    .tag-badge:hover {
       background-color:rgb(0, 0, 0);
        color:white;
        cursor: pointer;
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 1rem;
        margin-bottom: 2rem;
        justify-content: left;
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

    .edit-button {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color:transparent;
        color: #000;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
         text-decoration: none; 
        cursor: pointer;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        font-family: 'Schoolbell', cursive;
        border: 2px solid black;
        color: black;
    }

    .edit-button:hover {
         background-color:black;
        color: white;
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
        padding: 8px 12px;
        border-radius: 26px;
        font-size: 1rem;
        display: flex;
        align-items: center;
        cursor: pointer;
        background-color: transparent;
        color: black;
        border: 1px solid black; /* ✅ FIXED */
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

      .tag:hover {
        transform: translateY(-2px);
    }

    .tag i {
        margin-left: 5px;
        font-size: 1.2rem;
    }

    .entry-title {
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis; 
        max-width: 100%; 
        }

    .see-more-btn {
        background-color: transparent;
        border: 2px rgb(0, 0, 0);
        color:rgb(199, 153, 25);
        padding: 8px 12px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 10px;
        font-family: 'Schoolbell', cursive;
        transition: all background-color 0.3s;
    }

    .see-more-btn:hover {
        transform: translateY(-2px);    
        
    }


    .hidden-tag {
        display: none;
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0s 0.3s;
        }

    .hidden-tag.show {
        display: inline-flex;
        max-height: 100px;
        visibility: visible;
        transition: opacity 0.3s ease, visibility 0s 0s;
        opacity: 1;
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
      max-height: 500px; 
        overflow-y: auto;
        padding-right: 0.5rem;
        margin-top: 1rem;

        
}

#word-count {
    position: absolute;
    bottom: 2rem;
    right: 2rem;
    font-family: 'Schoolbell', cursive;
    font-size: 1.1rem;
    color: #555;
    margin-top: 0; 
}


 @media (max-width: 768px) {

        .navbar {
            flex-direction: column;
            align-items: center;
            padding: 1rem;
        }

        .navbar-right {
            margin-top: 1rem;
        }
    }



</style>

<div class="navbar">
    <div class="navbar-left"></div> 
    <div class="navbar-center">memoir</div>
    <div class="navbar-right">
    </div>
</div>

<div class="single-entry-container position-relative">
    <a href="{{ url('/view-all-thoughts') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
    </a>

    <h1 class="entry-title">{{ $entry->title }}</h1>
    @if ($entry->favorite)
        <div style="margin-top: 0.1rem, font-size: 0.95rem; color: #e74c3c; font-family: 'Schoolbell', cursive;">
            <i class="fas fa-heart"></i> added to favorites!
        </div>
    @endif

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

        @if (count($hiddenTags) > 0)
            <button class="see-more-btn">See More</button>
        @endif
    </div>
    <div class="entry-body-wrapper">
        <div class="entry-body">{!! $entry->body !!}</div>
    </div>
    
    <div id="word-count">
        word count: <span id="count">0</span>
    </div>


    <a href="{{ route('entries.edit', $entry->id) }}" class="edit-button">edit</a>
</div>

    <div class="text-center mt-4 text-muted small">
        &copy; 2025 Memoir
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
const entryBody = document.querySelector(".entry-body");
const wordCountElement = document.getElementById("count");

if (entryBody && wordCountElement) {
    const text = entryBody.textContent || entryBody.innerText || "";
    const wordCount = text.trim().split(/\s+/).filter(word => word.length > 0).length;
    wordCountElement.textContent = wordCount;
}

</script>

@endsection
