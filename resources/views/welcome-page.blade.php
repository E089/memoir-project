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
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 500;
        font-size: 1.5rem;
        font-family: 'Schoolbell', cursive;
    }

    .navbar-right {
        display: flex;
        gap: 1rem;
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

    .home-right {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .welcome-button {
        background-color: black;
        color: white;
        font-size: 1.50rem; /* Increased font size */
        padding: 1.50rem 3rem;  /* Increased padding */
        width: 100%; /* Ensure full width */
        text-decoration: none;
        border-radius: 40px;
        transition: background-color 0.3s ease;
        text-align: center;
        font-family: 'Schoolbell', cursive;
        border: none;
        margin-top:30px;
        display: inline-block;
    
    }

    .home-button:hover {
        background-color: #333;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 3.5rem;
            line-height: 1.1;
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

    .features-container {
    display: flex;
    justify-content: center;
    gap: 2rem;
    position: relative;
    margin-top: 3rem; /* Adjusted margin for spacing */
}

.feature-card {
    background: #FFDB4C;
    padding: 2rem;
    font-family: 'Fragment Mono', monospace;
    max-width: 300px;
    width: 100%;
    box-sizing: border-box;
    position: relative;
    z-index: 1; /* Ensure it's above the background */
    transition: transform 0.3s ease;
}

.feature-card h3 {
    margin-bottom: 1rem;
}

.feature-card p {
    color: #333;
}

.feature-card:hover {
    transform: scale(1.05); /* Add subtle hover effect */
}

.feature-card.overlap {
    position: absolute;
    top: 0; /* Start overlapping from the top */
    left: 50%;
    transform: translateX(-50%) translateY(-30%); /* Move it slightly upwards and horizontally centered */
    z-index: 0; /* Send it behind the first card */
}

@media (max-width: 768px) {
    .features-container {
        flex-direction: column;
        gap: 1.5rem;
        align-items: center;
    }

    .feature-card {
        max-width: 90%;
    }

    .feature-card.overlap {
        position: relative;
        transform: none; /* Reset the overlap effect on small screens */
        z-index: 1; /* Bring it to the front */
    }
    }
    .contact-section {
    background-color: #f9f9f9;
    padding: 4rem 2rem;
    text-align: center;
    }

    .contact-section h2 {
        font-family: 'Inter', sans-serif;
        margin-bottom: 2rem;
        text-align: center;
    }

    .contact-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-family: 'Fragment Mono', monospace;
    }

    .contact-container p {
        margin: 1rem 0;
        font-size: 1.1rem;
    }

    .contact-container a {
        color: #FFDB4C;
        text-decoration: none;
    }

    .contact-container a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .contact-container {
            padding: 1.5rem;
        }
        
        .contact-container p {
            font-size: 0.9rem;
        }
    }


    html {
    scroll-behavior: smooth;
    }
</style>

<!-- Navigation bar -->
<div class="navbar">
    <div class="navbar-left"></div>
    <div class="navbar-center">memoir</div>
    <div class="navbar-right">
        <a href="#home">home.</a>
        <a href="#about">about.</a>
        <a href="#contact">contact us.</a>
    </div>
</div>

<!-- Hero Section -->
<div id="home" class="main-section" style="margin-top: 0rem;">
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
        <a href="{{ route('register') }}" class="welcome-button" >Login or Sign up</a>
    </div>
</div>




@endsection