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
    padding-right: 2rem; /* Add more or less spacing here */
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
        border: 2px solid black; /* now has a black outline */
        margin-top: 30px;
        display: inline-block;
    }

    .home-button:hover {
        background-color: #FFDB4C; /* soft yellow */
        color: black; /* keep text readable */
        border-color: #FFDB4C; /* match border to background */
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
            flex-direction: row; /* Changed from column to row */
            justify-content: center; /* Center horizontally */
            align-items: center;
            gap: 2rem; /* Adjusted spacing between buttons */
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

    .feature-card:hover {
    animation: pulse 0.8s infinite;
    transform: scale(1.05);  /* Slightly enlarge the card on hover */
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


</style>

<!-- Navigation bar -->
<div class="navbar">
    <div class="navbar-left"></div> <!-- Invisible spacer to help centering -->
    <div class="navbar-center">memoir</div>
    <div class="navbar-right">
        <a href="{{ route('logout') }}" class="logout-button">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>



<!-- Hero Section -->
<div class="main-section" style="margin-top: 40rem;">
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


<!-- Features Section -->
<div class="features-section">
    <h2>Recent</h2>
    <div class="features-container">
        @foreach ($entries as $entry)
            <div class="feature-card">
                <a href="{{ route('entries.show', $entry->id) }}" class="text-dark text-decoration-none">
                    <h3>{{ $entry->title }}</h3>
                    <p>{{ Str::limit($entry->body, 100) }}</p>
                </a>
            </div>
        @endforeach
    </div>
</div>




@endsection