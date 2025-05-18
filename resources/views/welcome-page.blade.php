@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Schoolbell&family=Inter:wght@300;400;600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Fragment+Mono&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Archivo:wght@600&display=swap');
    @import url('https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css');

    
    @keyframes paintReveal {
        0% {
            clip-path: inset(0 100% 0 0);
        }
        100% {
            clip-path: inset(0 0 0 0);
        }
    }

    .painted-reveal {
    animation: paintReveal 1.2s ease-out forwards;
    overflow: hidden;
    }

    

    html, body {
        height: auto;
        min-height: 100%;
        margin: 0;
        padding: 0;
        
        background: url('{{ asset('welcome.png') }}') no-repeat center center fixed;
        background-size: cover;
        overflow-x: hidden;
    }

    .navbar {
        
        display: flex;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
    .panel {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(4px);
        /* border-radius: 20px; */
        padding: 6rem 2rem;
        /* margin: 1rem auto; */
        width: 500%;
        max-width: 150%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-left:-20rem
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
        margin-top:50rem;
        margin-bottom:15rem;
        font-size:700;
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
        margin-top:20rem;
        gap: 1rem;
    }

    .welcome-button {
        background-color: transparent;
        color: black;
        font-size: 1.50rem; 
        padding: 1.50rem 3rem;
        width: 100%; 
        text-decoration: none;
        border-radius: 40px;
        transition: background-color 0.3s ease;
        text-align: center;
        font-family: 'Schoolbell', cursive;
        border: 2px solid black;
        margin-top:30px;
        display: inline-block;
    }

    .welcome-button:hover {
        background-color: #FFDB4C; 
        color: black; 
        border-color: #FFDB4C; 
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
            flex-direction: row; 
            justify-content: center; 
            align-items: center;
            gap: 2rem; 
        }
    }

    .features-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        position: relative;
        margin-top: 3rem; 
    }

    .feature-card {
        background: #FFDB4C;
        padding: 2rem;
        font-family: 'Fragment Mono', monospace;
        max-width: 300px;
        width: 100%;
        box-sizing: border-box;
        position: relative;
        z-index: 1; 
        transition: transform 0.3s ease;
    }

    .feature-card h3 {
        margin-bottom: 1rem;
    }

    .feature-card p {
        color: #333;
    }

    .feature-card:hover {
        transform: scale(1.05); 
    }

    .feature-card.overlap {
        position: absolute;
        top: 0; 
        left: 50%;
        transform: translateX(-50%) translateY(-30%); 
        z-index: 0; 
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
        transform: none; 
        z-index: 1; 
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

<div class="navbar">
    <div class="navbar-left"></div>
    <div class="navbar-center">memoir</div>
    <div class="navbar-right">
        <a href="#home">home.</a>
        <a href="#about">about.</a>
        <a href="#contact">contact us.</a>
    </div>
</div>

<div id="home" class="main-section" style="margin-top: 40rem;">
    <div class="hero" data-aos="fade-right" style="margin-left:5rem;">
        <h1 style="line-height: 0.80;">
            <span  style="font-family:'Fragment Mono', monoscape">type down</span>
            <span style="font-family:'Schoolbell', cursive; margin-left:50px; font-size:7rem;">your</span>
            <span class="bold" style="font-family:'Arial', sans-serif; font-weight:1500px; font-size:120px; letter-spacing:0.5">inner world.</span>
        </h1>
        <p style="font-size:25px;">Memoir is your digital journal — crafted to hold your thoughts, memories, and life’s little details.</p>
    </div>

    <div class="home-right" style="font: size 30px;" data-aos="slide-up">
        <a href="{{ route('register') }}" class="welcome-button" >Login or Sign up</a>
    </div>
</div>

<div id="about" class="panel">
    <div class="about-content paint-reveal" style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-start;"  >
        <div style="flex: 1; min-width: 200px; margin-top:100px;">
            <h3 style="font-family:'Fragment Mono', monospace; margin-left:15rem;font-size:80px;line-height:0.90">
                What is<br>
                <span style="margin-left: 40px; font-family:'Schoolbell', cursive;font-size:6rem;margin-top:20px;">memoir?</span>
            </h3>
        </div>
        <div style="flex: 2; font-size:25px;font-family:'Fragment Mono', monospace; margin-left:2rem;">
            <div style="max-width: 400px; margin-left:20rem;background-color:rgb(255, 239, 19);padding: 2rem 2rem;">
                <p> Memoir is a peaceful corner of the internet where you can write, remember, and reflect.<br></span></p>
            </div>
            <div style="max-width: 400px; margin-left:35rem;font-family:'Fragment Mono', monospace;background-color:rgb(255, 239, 19);padding: 2rem 2rem;">
                <p>Whether it’s a travel memory, a daily thought, or a life-changing moment— Memoir gives you the space to preserve it.</span></p>
            </div>
        </div>
    </div>
</div>

<div class="panel" style="background-color: #f2f2f0;">
    <h2 style="font-family: 'Schoolbell', cursive; font-size: 4rem; text-align: center;">we believe in</h2>
    <div style="display: flex; flex-wrap: wrap; justify-content: space-around; text-align: center; margin-top: 2rem;">
        <div style="max-width: 300px;font-family:'Fragment Mono', monscapce;">
            <h5>Writing is healing</h5>
            <p>Self-expression helps us understand who we are.</p>
        </div>
        <div style="max-width: 300px;font-family:'Fragment Mono', monscapce;">
            <h5>Memories Matter</h5>
            <p>Even the little things deserve to be remembered.</p>
        </div>
        <div style="max-width: 300px;font-family:'Fragment Mono', monscapce;">
            <h5>Simplicity is power</h5>
            <p>A clean, quiet space encourages true reflection.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1200,
        once: true,
    });
</script>

@endsection