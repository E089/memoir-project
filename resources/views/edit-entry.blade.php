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
        max-width: 1000px;
        margin: 2rem auto; */
        background: #FFDB4C;
        background-color: #FFDB4C;
        padding: 3rem 2rem;
        position: relative;
        transform: rotate(-3deg);
        margin: 2rem auto;
        box-shadow: 20px 20px 3px rgba(0, 0, 0, 0.2);
        height: 800px;
        scrollbar-width: none;

      
    }

    .save-button {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color:transparent;
        border: 1px none;
        color: #000;
        padding: 0.5rem 1rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        cursor: pointer;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        font-family: 'Schoolbell', cursive;
        border: 2px solid black;
    }

    .save-button:hover {
        background-color: #ffe873;
        background-color:black;
        color: white;
    }

    .edit-entry-container input[type="text"],
    .edit-entry-container textarea,
    .edit-entry-container select {
        width: 100%;
        border: none;
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
        top: -20px;
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

    .navbar-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 500;
        font-size: 1.5rem;
        font-family: 'Schoolbell', cursive;
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
        background-color:transparent;
        color: #333;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
        max-width: 200px;
        white-space: nowrap;
        border: 2px solid black;
        margin-bottom:30px;

    }

    .tag i {
        margin-left: 0.5rem;
        cursor: pointer;
        color:rgb(19, 17, 17);
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
        font-size: 13px;
        padding: 4px 6px;
        min-width: 100px;
        flex-grow: 1;
        background: transparent;
    }

    .input-tag {
        border: none;
        outline: none;
        font-size: 13px;
        padding: 4px 6px;
        min-width: 100px;
        flex-grow: 1;
        background: transparent;
    }


    #editor {
        height: 350px; 
        overflow-y: auto;
        border-color:transparent;
        padding: 1rem;
        font-family:'Fragment Mono', 'monospace';   
    }
    .favorite-button {
        position: absolute;
        top: 27px;
        right: 90px; 
        background: none;
        border: none;
        font-family: 'Schoolbell', cursive;
        font-size: 1.4rem; 
        color: #666;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color 0.3s ease;
    }

    .favorite-button i {
    color: gray;
    font-size: 1.6rem; 
    transition: color 0.3s ease;
}


    .favorite-button.added {
        color: #e63946;
    }

    .favorite-button.added i {
        color: #e63946;
    }

    .favorite-button:hover i {
        animation: pulse 0.4s ease-in-out;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.3);
        }
        100% {
            transform: scale(1);
        }
    }

    .heart-pop {
        position: absolute;
        font-size: 20px;
        animation: pop 0.6s ease-out forwards;
        opacity: 0;
        pointer-events: none;
        color: #e63946;
    }

    @keyframes pop {
        0% {
            transform: scale(0.5) translate(0, 0);
            opacity: 1;
        }
        100% {
            transform: scale(1.2) translate(var(--x), var(--y));
            opacity: 0;
        }
    }

</style>

<div class="navbar">
    <div class="navbar-left"></div>
    <div class="navbar-center">memoir</div>
</div>

<div class="edit-entry-container">
     <a href="{{ url('/view-all-thoughts') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> 
    </a>

    <h1>Edit Your Entry</h1>
    <form action="{{ route('entries.update', $entry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="title" id="title" value="{{ $entry->title }}" placeholder="Edit your title..." required>

        <textarea name="body" id="body" hidden>{{ $entry->body }}</textarea>

        <div id="editor">{!! $entry->body !!}</div>

        <div id="word-count" style="text-align:right; font-family: 'Schoolbell', cursive; font-size: 0.9rem; margin-top: -10px; margin-bottom: 20px; color:#333;">
            Word count: 0
        </div>


       <select name="category_id" id="category" style="margin-bottom: 1rem;">
            <option value="">Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $entry->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        <div class="tags-container" id="tags-container">
                @foreach ($entry->tags as $tag)
                    <div class="tag" title="{{ $tag->name }}">
                        <span class="tag-text">{{ $tag->name }}</span>
                        <i class="fas fa-times"></i>
                    </div>
                @endforeach
                <input type="text" id="tag-input" placeholder="Add a tag..." class="input-tag" style="flex: 1; min-width: 120px; border: none; outline: none;">
            </div>
            <button type="button" id="favorite-btn" class="favorite-button" title="Add to Favorite">
                    <i class="fas fa-heart"></i>
            </button>
                <input type="hidden" name="tags" id="tags-input">
                <button type="submit" class="save-button">Save</button>
                <input type="hidden" name="favorite" id="favorite-hidden" value="0">
            </form>
        </div>

<script>
    let lastToastrMessage = null;
        let lastToastrTime = 0;

        function showToastr(type, message, title) {
            const now = Date.now();
            if (lastToastrMessage === message && now - lastToastrTime < 2000) {
                return; 
            }

            lastToastrMessage = message;
            lastToastrTime = now;

            toastr[type](message, title, {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-center"
            });
        }
    document.getElementById('tag-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            const tagInput = e.target;
            const tagValue = tagInput.value.trim();

            const tagElements = document.querySelectorAll('.tag');
            if (tagElements.length >= 9) {
                showToastr('error', "You can only add up to 9 tags.", "🚫 Limit Reached");
                return;
            }

             if (tagValue.length > 20) {
                showToastr('warning', "Tag must not exceed 20 characters.", "⚠️ Too Long");
                return;
            }

            if (!tagValue) return;

            const existingTags = Array.from(document.querySelectorAll('.tag'))
                .map(tag => tag.innerText.trim().replace(' ×', '').toLowerCase());

             if (existingTags.includes(tagValue.toLowerCase())) {
                showToastr('warning', "This tag already exists!", "⚠️ Duplicate");
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

        tagElement.querySelector('i').addEventListener('click', function () {
            tagElement.remove();
            updateTagsInput();
        });

        tagElement.addEventListener('dblclick', function () {
            const inputField = document.createElement('input');
            inputField.value = tagValue;
            tagElement.innerHTML = '';
            tagElement.appendChild(inputField);
            inputField.focus();

            inputField.addEventListener('blur', function () {
                let newValue = inputField.value.trim();

                if (newValue.length > 20) {
                    showToastr('warning', "Tag must not exceed 20 characters.", "⚠️ Too Long");
                    return;
                }

                const otherTags = Array.from(document.querySelectorAll('.tag'))
                    .filter(tag => tag !== tagElement)
                    .map(tag => tag.innerText.trim().replace(' ×', '').toLowerCase());

                if (otherTags.includes(newValue.toLowerCase())) {
                    showToastr('warning', "This tag already exists!", "⚠️ Duplicate");
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

    window.addEventListener('DOMContentLoaded', () => {
        const tagElements = document.querySelectorAll('.tag');
        tagElements.forEach(tagEl => {
            const textSpan = tagEl.querySelector('.tag-text');
            const tagValue = textSpan ? textSpan.textContent.trim() : tagEl.textContent.trim().replace('×', '');

            const newTag = createTagElement(tagValue);
            tagEl.replaceWith(newTag);
        });

        updateTagsInput(); 
    });
    </script>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
    const btn = document.getElementById('favorite-btn');
    const favoriteHidden = document.getElementById('favorite-hidden');
    const form = document.querySelector('form');

    function heartPop() {
        const rect = btn.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;

        for (let i = 0; i < 8; i++) {
            const heart = document.createElement('div');
            heart.classList.add('heart-pop');
            heart.textContent = '❤️';

            const angle = (Math.PI * 2 * i) / 8;
            const distance = 30 + Math.random() * 20;

            const offsetX = Math.cos(angle) * distance;
            const offsetY = Math.sin(angle) * distance;

            heart.style.position = 'fixed';
            heart.style.left = `${centerX - 10}px`;
            heart.style.top = `${centerY}px`;
            heart.style.setProperty('--x', `${offsetX}px`);
            heart.style.setProperty('--y', `${offsetY}px`);

            document.body.appendChild(heart);
            setTimeout(() => heart.remove(), 600);
        }
    }

    btn.addEventListener('click', function () {
        btn.classList.toggle('added');

        const isFavorite = btn.classList.contains('added');
        if (isFavorite) {
            heartPop();
        }
    });

    form.addEventListener('submit', function (e) {
        const isFavorite = btn.classList.contains('added');
        favoriteHidden.value = isFavorite ? '1' : '0';
    });

    window.addEventListener('DOMContentLoaded', () => {
        const isFavorite = {{ $entry->favorite ? 'true' : 'false' }};
        if (isFavorite) {
            btn.classList.add('added');
        }
    });

</script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    const wordCountDiv = document.getElementById('word-count');

    function updateWordCount() {
        const text = quill.getText().trim();
        const words = text.length ? text.split(/\s+/).filter(Boolean) : [];
        wordCountDiv.textContent = `Word count: ${words.length}`;
    }

    quill.on('text-change', updateWordCount);
    updateWordCount(); 

    document.querySelector('form').addEventListener('submit', function (e) {
        const content = quill.getText().trim(); 

        if (content.length === 0) {
            e.preventDefault(); 
            alert("Please fill in the body before submitting.");
            return;
        }

        document.querySelector('#body').value = quill.root.innerHTML;
    });
</script>

    @endsection