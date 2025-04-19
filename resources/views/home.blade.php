@extends('layouts.app')

@section('content')
<!-- Default fonts, no custom font needed -->
<style>
    /* Container for the home page */
    .home-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 3rem;
    }

    /* Left section with text */
    .home-left {
        flex: 1;
        text-align: left;
    }

    .home-left h1 {
        font-size: 3rem;
        color: #333;
        margin-bottom: 1rem;
    }

    .home-left p {
        font-size: 1.2rem;
        color: #666;
    }

    /* Right section with buttons */
    .home-right {
        flex: 0 0 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .home-button {
        display: inline-block;
        background-color: black;
        color: white;
        font-size: 1.2rem;
        padding: 1rem 2rem;
        text-decoration: none;
        border-radius: 25px;
        margin: 10px 0;
        transition: background-color 0.3s ease;
        width: 100%;
        text-align: center;
    }

    .home-button:hover {
        background-color: #333;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .home-container {
            flex-direction: column;
            padding: 2rem;
        }

        .home-left {
            text-align: center;
            margin-bottom: 2rem;
        }

        .home-right {
            flex: 0 0 100%;
            align-items: center;
        }

        .home-button {
            font-size: 1rem;
            padding: 0.8rem 1.5rem;
        }
    }
</style>

<div class="home-container">
    <!-- Left Section -->
    <div class="home-left">
        <h1>Type Down Your Inner World</h1>
        <p>Memoir is a place where your thoughts are free to roam. Capture your stories, your ideas, and your dreams, and preserve them for yourself.</p>
    </div>

    <!-- Right Section -->
    <div class="home-right">
        <a href="{{ route('start-writing') }}" class="home-button">Start Writing</a>
        <a href="{{ route('view-all-thoughts') }}" class="home-button">View All Thoughts</a>
    </div>
</div>

@endsection
