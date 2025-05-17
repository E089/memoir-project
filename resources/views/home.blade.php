@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Schoolbell&family=Inter:wght@300;400;600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Fragment+Mono&display=swap');

    html, body {
        height: auto;
        min-height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        background: url('{{ asset('images/bg_home.png') }}') no-repeat center center fixed;

        background-size: cover;
        overflow-x: hidden;
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
    flex: 0;
    text-align: center;
    font-weight: 500;
    font-size: 1.5rem;
    font-family: 'Schoolbell', cursive;
    }

    .navbar-left,
    .navbar-right {
        flex: 1;
    }

    .navbar-right {
    display: flex;
    justify-content: flex-end;
    padding-right: 2rem; 
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

    .main-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8rem 4rem 4rem;
        gap: 4rem;
        flex-wrap: wrap;
        margin-top: 8rem;
    }


    .hero {
        text-align: left;
        max-width: 600px;
        margin-left: -50px;
    }

    .hero h1 {
        font-size: 6rem;
        line-height: 1.05;
        margin-bottom: 2rem;
        margin-left: -90px;
    }

    .hero h1 span {
        display: block;
    }

    .hero h1 .bold {
        font-weight: bold;
    }

    .hero p {
        margin-top: 2rem;
        font-size: 1rem;
        letter-spacing: 0.02em;
        color: #333;
        font-family: 'Fragment Mono', monospace;
        margin-left: -90px;
    }

    h3 {
        font-family: 'Schoolbell', cursive;
        font-size: 2rem;
        margin-top: px;
        
    }

    .home-right {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .home-button {
        background-color: transparent;
        color: black;
        font-size: 1.5rem;
        padding: 1.5rem 3rem;
        width: 100%;
        text-decoration: none;
        border-radius: 40px;
        transition: all 0.3s ease;
        text-align: center;
        font-family: 'Schoolbell', cursive;
        border: 2px solid black;
        margin-top: 30px;
        display: inline-block;
    }

    .home-button:hover {
        background-color: #FFDB4C; 
        color: black; 
        border-color: #FFDB4C; 
    }


    @media (max-width: 768px) {
        .hero h1 {
            font-size: 3.5rem;
            line-height: 1.1;
        }

        .main-section {
            flex-direction: column;
            text-align: center;
            padding: 10rem 2rem 2rem;
        }

        .navbar {
            flex-direction: column;
            align-items: center;
            padding: 1rem;
        }

        .navbar-right {
            margin-top: 1rem;
        }

        .home-right {
            margin-top: 2rem;
            margin-left:2rem;
            display: flex;
            flex-direction: row; 
            justify-content: center; 
            align-items: center;
            gap: 2rem; 
        }
    }

    .features-section {
        margin-top: 10rem;
        margin-bottom: 10rem;
        padding: 4rem;
        text-align: center;
        
    }

    .features-section h2 {
        font-size: 2.5rem;
        font-family: 'Schoolbell', cursive;
        margin-bottom: 6rem;
    }

    .features-container {
        display: flex;
        
        justify-content: center;
        gap: 3rem;
    }

    .feature-card {
        flex: 1 1 250px;
        max-width: 300px;
        background: #FFDB4C;
        padding: 2rem;
        
        font-family: 'Fragment Mono', monospace;

        transition: transform 0.3s ease;
    }

    .feature-card p {
    white-space: pre-line; 
    overflow: hidden;
    text-overflow: ellipsis; 
    max-height: 5em; 
    font-family: 'Fragment Mono', monospace;
    line-height: 1.5;
    margin-bottom: 1.5rem; 
    }


    .feature-card:hover {
    animation: pulse 0.8s infinite;
    transform: scale(1.05);  
    }

    @keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
    }

    .feature-card h3 {
        margin-bottom: 1rem;
        white-space: nowrap;       
        overflow: hidden;           
        text-overflow: ellipsis;    
        max-width: 250px;          
    }

    .logout-button {
        background-color: transparent;
        border: 2px solid black;
        color: black;
        font-family: 'Schoolbell', cursive;
        border-radius: 25px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .logout-button:hover {
        background-color: #FFDB4C;
        border-color: #FFDB4C;
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

    .text-truncate-multiline {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.5em;
    max-height: 4.5em; /* 3 lines x 1.5em */
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

    
    /* Ellipsis Styling */
    max-width: 70px; /* Adjust to match approx. 5 characters */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: inline-block;
    vertical-align: middle;
    }

    .card-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%; /* Adjust the max width if necessary */
    display: block;
    font-size: 1.5rem; /* Adjust as needed */
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

    .recent-title {
    font-family: 'Schoolbell', cursive;
    font-size: 2.5rem;
    color: #000;
    background-color: #FFDB4C;
    display: inline-block;
    padding: 0.5rem 2rem;
    border-radius: 40px;
    box-shadow: 2px 2px 0px #000;
}


</style>

<!-- Navigation bar -->
<div class="navbar">
    <div class="navbar-left"></div> <!-- Invisible spacer to help centering -->
    <div class="navbar-center">memoir</div>
    <div class="navbar-right">
        <a href="{{ route('logout') }}" class="logout-button" id="logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

<!-- Hero Section -->
<div class="main-section">
    <div class="hero">
        <h1>
            <span>type down</span>
            <span><em>your</em></span>
            <span class="bold">inner world.</span>
        </h1>
        <p>Memoir is your digital journal — crafted to hold your thoughts, memories, and life’s little details.</p>
    </div>

    <!-- Right Section -->
    <div class="home-right" style="font: size 30px;">
        <a href="{{ route('start-writing') }}" class="home-button" >     Start Writing     </a>
        <a href="{{ route('view-all-thoughts') }}" class="home-button">Wall of Thoughts</a>
    </div>
</div>

<div class="container mt-4">
    <div class="recent-header text-center mb-5">
            <h2 class="recent-title">recent ✿</h2>
    </div>

    <div class="scrollable-wall p-2">
        <div class="row">
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
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>





@endsection