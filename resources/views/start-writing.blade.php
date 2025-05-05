@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: auto;
        min-height: 100%;
        margin: 0;
        padding: 0;
        background: url('{{ asset('bg_login.png') }}');
        background-position: center;
        background-repeat: no-repeat;
        background-size: 1950px;
        overflow-x: hidden;
    }

    .writing-container {
        max-width: 3000rem;
        background: #fffef5;
        padding: 4rem 3rem;
        border-radius: 14px;
        position: relative;
        border: 1px solid #e0e0e0;
        font-family: 'Schoolbell', cursive;
        margin-top: -38px;
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
        font-family: 'Schoolbell', cursive;
    }

    .save-button:hover {
        background-color: #ffe873;
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

    .writing-container input[type="text"],
    .writing-container textarea,
    .writing-container select {
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

    .writing-container textarea {
        height: 250px;
        resize: vertical;
    }

    .entry-heading {
        font-size: 1.8rem;
        text-align: center;
        margin-bottom: 2rem;
        color: #444;
        font-family: 'Schoolbell', cursive;
    }

    .navbar-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 500;
        font-size: 1.5rem;
        font-family: 'Schoolbell', cursive;
        margin-top: 40px;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 4rem;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .navbar a {
        text-decoration: none;
        color: black;
        font-size: 1rem;
        padding: 0.5rem 1rem;
        border: 1px solid black;
        border-radius: 25px;
        font-family: 'Schoolbell', cursive;
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 2rem;
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
    }

    .tag:hover {
        background-color: #ffe873;
    }

    .tag i {
        margin-left: 5px;
        font-size: 1rem;
    }

    .tag input {
    border: none;
    background: transparent;
    font-size: 1rem;
    color: #333;
    outline: none;
    width: auto; /* Let it shrink to the tag's size */
    text-align: center;
    min-width: 30px; /* Make it smaller by default */
    max-width: 100px; /* You can adjust this to make it more compact */
    padding: 2px 4px; /* Reduce the padding for a more compact feel */
    }

    .tag input:focus {
        border-bottom: 1px solid #333; /* Keeps a subtle underline when focused */
    }

    .add-tag {
        background-color: #ffde59;
        border: none;
        color: #333;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: background-color 0.3s;
    }

    .add-tag:hover {
        background-color: #ffe873;
    }

    .add-tag i {
        margin-right: 5px;
    }

    #editor-container {
    height: 200px;
    margin-bottom: 2rem;
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow-y: auto;
    }

    #editor {
        height: 100%;
        font-family: 'Fragment Mono', monospace;
    }

</style>

<div class="navbar">
    <div class="navbar-left"></div>
    <div class="navbar-center">memoir</div>
</div>

<div class="writing-container">
    <!-- 🡐 Back Button -->
    <a href="{{ url('/home') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> 
    </a>

    <div class="entry-heading">Start Writing</div>

    <form method="POST" action="{{ url('/start-writing') }}">
        @csrf

        <input type="text" id="title" name="title" placeholder="Title..." required>

      <!-- Quill Editor -->
        <div id="editor-container">
            <div id="editor"></div>
        </div>
        <input type="hidden" name="body" id="body">


        <select id="category_id" name="category_id">
            <option value="">Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

         <!-- Tags Section -->
         <div class="tags-container" id="tags-container">
        <!-- Tags will appear here -->
        </div>

        <input type="text" id="tag-input" placeholder="Add a tag..." class="input-tag" style="margin-bottom: 1rem;">

        <button type="button" class="add-tag" id="add-tag-btn">
            <i class="fas fa-plus"></i> Add Tag
        </button>

        <!-- Submit button -->
        <input type="hidden" name="tags" id="tags-input">
        <button type="submit" class="save-button">Save</button>
    </form>
</div>

<script>
document.getElementById('add-tag-btn').addEventListener('click', function() {
    let tagInput = document.getElementById('tag-input');
    let tagValue = tagInput.value.trim();

    if (tagValue.length > 20) {
        alert("Tag must not exceed 20 characters.");
        return;
    }

    if (!tagValue) return;

    // Check for duplicate tags (case insensitive)
    const existingTags = Array.from(document.querySelectorAll('.tag'))
        .map(tag => tag.innerText.trim().replace(' ×', '').toLowerCase());

    if (existingTags.includes(tagValue.toLowerCase())) {
        alert("This tag already exists.");
        return;
    }

    // Create the tag element
    let tagElement = document.createElement('div');
    tagElement.classList.add('tag');
    tagElement.innerHTML = `${tagValue} <i class="fas fa-times"></i>`;

    // Delete functionality
    tagElement.querySelector('i').addEventListener('click', function() {
        tagElement.remove();
        updateTagsInput();
    });

    // Edit functionality
    tagElement.addEventListener('dblclick', function() {
        let inputField = document.createElement('input');
        inputField.value = tagValue;
        tagElement.innerHTML = '';
        tagElement.appendChild(inputField);
        inputField.focus();

        inputField.addEventListener('blur', function() {
            let newValue = inputField.value.trim();

            if (newValue.length > 20) {
                alert("Tag must not exceed 20 characters.");
                inputField.focus();
                return;
            }

            // Check for duplicates again on edit (excluding self)
            const otherTags = Array.from(document.querySelectorAll('.tag'))
                .filter(tag => tag !== tagElement)
                .map(tag => tag.innerText.trim().replace(' ×', '').toLowerCase());

            if (otherTags.includes(newValue.toLowerCase())) {
                alert("This tag already exists.");
                inputField.focus();
                return;
            }

            if (newValue) {
                tagElement.innerHTML = `${newValue} <i class="fas fa-times"></i>`;
                tagElement.querySelector('i').addEventListener('click', function() {
                    tagElement.remove();
                    updateTagsInput();
                });
                updateTagsInput();
            } else {
                tagElement.remove();
                updateTagsInput();
            }
        });

        inputField.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                inputField.blur();
            }
        });
    });

    document.getElementById('tags-container').appendChild(tagElement);
    tagInput.value = '';
    updateTagsInput();
});

function updateTagsInput() {
    const tags = [];
    document.querySelectorAll('.tag').forEach(tag => {
        tags.push(tag.innerText.trim().replace(' ×', ''));
    });
    document.getElementById('tags-input').value = JSON.stringify(tags);
}
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
