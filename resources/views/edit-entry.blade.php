@extends('layouts.app')

@section('content')
<style>

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

    .edit-entry-container {
        max-width: 700px;
        margin: 3rem auto;
        background: #fffef5;
        padding: 3rem 2rem;
        border-radius: 12px;
        position: relative;
        border: 1px solid #e0e0e0;
    }

    .save-button {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #ffde59;
        border: none;
        color: #000;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        font-family: 'Comic Neue', cursive;
    }

    .save-button:hover {
        background-color: #ffe873;
    }

     .edit-entry-container input[type="text"],
    .edit-entry-container textarea,
    .edit-entry-container select {
        width: 100%;
        border: none;
        border-bottom: 1px solid #bbb;
        padding: 0.8rem 0;
        margin-bottom: 2rem;
        font-size: 1.1rem;
        background: transparent;
        outline: none;
        font-family: 'Fragment Mono', monospace;
    }

    .edit-entry-container textarea {
        height: 250px;
        resize: vertical;
    }

    .form-group label {
        display: none;
    }

    h1 {
        font-size: 2rem;
        margin-bottom: 1.5rem;
        font-family: 'Schoolbell', cursive;
        color: #444;
        text-align: center;
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
    
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 6px;
        min-height: 40px;
        align-items: center;
        }

    .tag {
        background-color: #e0e0e0;
        color: #333;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
        max-width: 200px;
        white-space: nowrap;
    }

    .tag i {
        margin-left: 0.5rem;
        cursor: pointer;
        color: #007acc;
    }

    .tag input {
        border: none;
        background: transparent;
        font-size: 0.875rem;
        outline: none;
        width: auto;
    }

   .input-tag {
        border: none;
        outline: none;
        font-size: 10px;
        min-width: 120px;
        background: transparent;
        margin-top: 10px;
        align-items: center;
    }

    #editor {
    height: 400px; /* or any height you want */
    overflow-y: auto;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 1rem;
    background-color: #fffef5;
}


</style>


<!-- Navigation bar -->
<div class="navbar">
    <div class="navbar-left"></div>
    <div class="navbar-center">memoir</div>
</div>

<div class="edit-entry-container">
     <!-- 🡐 Back Button -->
     <a href="{{ url('/view-all-thoughts') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> 
    </a>

    <h1>Edit Your Entry</h1>
    <form action="{{ route('entries.update', $entry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="title" id="title" value="{{ $entry->title }}" placeholder="Edit your title..." required>

        <!-- Use a hidden textarea for submission -->
        <textarea name="body" id="body" hidden>{{ $entry->body }}</textarea>

        <!-- Show rich content in a div for editing -->
        <div id="editor">{!! $entry->body !!}</div>

        <select name="category_id" id="category">
            <option value="">Select a Category (Optional)</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $entry->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        <div class="tags-container" id="tags-container">
        <!-- Pre-populate existing tags -->
                @foreach ($entry->tags as $tag)
                    <div class="tag" title="{{ $tag->name }}">
                        <span class="tag-text">{{ $tag->name }}</span>
                        <i class="fas fa-times"></i>
                    </div>
                @endforeach

                <!-- Input field -->
                <input type="text" id="tag-input" placeholder="Add a tag..." class="input-tag" style="flex: 1; min-width: 120px; border: none; outline: none;">
            </div>

            <input type="hidden" name="tags" id="tags-input">
            <button type="submit" class="save-button">Save</button>
            </form>
        </div>

        <script>
document.getElementById('tag-input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        const tagInput = e.target;
        const tagValue = tagInput.value.trim();

         // Check if max tag limit is reached
        const tagElements = document.querySelectorAll('.tag');
        if (tagElements.length >= 10) {
            alert("You can only add up to 10 tags.");
            return;
        }


        if (tagValue.length > 20) {
            alert("Tag must not exceed 20 characters.");
            return;
        }

        if (!tagValue) return;

        const existingTags = Array.from(document.querySelectorAll('.tag'))
            .map(tag => tag.innerText.trim().replace(' ×', '').toLowerCase());

        if (existingTags.includes(tagValue.toLowerCase())) {
            alert("This tag already exists.");
            return;
        }

        const tagElement = createTagElement(tagValue);
        document.getElementById('tags-container').insertBefore(tagElement, tagInput);
        tagInput.value = '';
        updateTagsInput();
    }
});

function createTagElement(tagValue) {
    const tagElement = document.createElement('div');
    tagElement.classList.add('tag');
    tagElement.innerHTML = `${tagValue} <i class="fas fa-times"></i>`;

    // Delete
    tagElement.querySelector('i').addEventListener('click', function () {
        tagElement.remove();
        updateTagsInput();
    });

    // Edit on double-click
    tagElement.addEventListener('dblclick', function () {
        const inputField = document.createElement('input');
        inputField.value = tagValue;
        tagElement.innerHTML = '';
        tagElement.appendChild(inputField);
        inputField.focus();

        inputField.addEventListener('blur', function () {
            let newValue = inputField.value.trim();

            if (newValue.length > 20) {
                alert("Tag must not exceed 20 characters.");
                inputField.focus();
                return;
            }

            const otherTags = Array.from(document.querySelectorAll('.tag'))
                .filter(tag => tag !== tagElement)
                .map(tag => tag.innerText.trim().replace(' ×', '').toLowerCase());

            if (otherTags.includes(newValue.toLowerCase())) {
                alert("This tag already exists.");
                inputField.focus();
                return;
            }

            if (newValue) {
                const updatedTag = createTagElement(newValue);
                tagElement.replaceWith(updatedTag);
            } else {
                tagElement.remove();
            }
            updateTagsInput();
        });

        inputField.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                inputField.blur();
            }
        });
    });

    return tagElement;
}

function updateTagsInput() {
    const tags = [];
    document.querySelectorAll('.tag').forEach(tag => {
        tags.push(tag.innerText.trim().replace(' ×', ''));
    });
    document.getElementById('tags-input').value = JSON.stringify(tags);
}

// Enhance pre-populated tags
window.addEventListener('DOMContentLoaded', () => {
    const tagElements = document.querySelectorAll('.tag');
    tagElements.forEach(tagEl => {
        const textSpan = tagEl.querySelector('.tag-text');
        const tagValue = textSpan ? textSpan.textContent.trim() : tagEl.textContent.trim().replace('×', '');

        // Replace with a fresh tag element that has events
        const newTag = createTagElement(tagValue);
        tagEl.replaceWith(newTag);
    });

    updateTagsInput(); // Populate hidden input on load
});
</script>

<!-- Quill JS and CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        const content = quill.getText().trim(); // getText ignores HTML tags

        if (content.length === 0) {
            e.preventDefault(); // Stop form submission
            alert("Please fill in the body before submitting.");
            return;
        }

        // Transfer HTML content to hidden input if not empty
        document.querySelector('#body').value = quill.root.innerHTML;
    });
</script>

 
@endsection