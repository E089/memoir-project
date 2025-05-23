@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Schoolbell&family=Inter:wght@300;400;600&display=swap');
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

    .terms-container {
        max-width: 650px;
        margin: 4rem auto;
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        font-family: 'Inter', sans-serif;
        color: #333;
        text-align: left;
    }

    h1 {
        font-family: 'Schoolbell', cursive;
        font-size: 2.75rem;
        color: #FFDB4C;
        margin-bottom: 2rem;
    }

    .rule {
        margin-bottom: 2.5rem;
    }

    .rule h2 {
        font-size: 1.4rem;
        color: #555;
        margin-bottom: 0.5rem;
    }

    .rule p {
        font-size: 1rem;
        line-height: 1.6;
    }

    body.dark-mode .terms-container {
        background-color: #1e1e1e;
        color: #f0f0f0;
    }

    body.dark-mode h1 {
        color: #ffc9e1;
    }

    body.dark-mode .rule h2 {
        color: #ffd3ef;
    }
</style>

<div class="terms-container">
    <h1>📖 Memoir's Personal Terms</h1>

    <div class="rule">
        <h2>1. This Is Your Space 🛏️</h2>
        <p>Write what you want. Feel what you feel. This little corner is 100% yours, no judgment, no filters, no prying eyes.</p>
    </div>

    <div class="rule">
        <h2>2. Be Nice to Future You 💌</h2>
        <p>Try not to leave mean notes to yourself. One day you’ll read this again and deserve softness, not sass (unless it’s fun sass).</p>
    </div>

    <div class="rule">
        <h2>3. Don't Hack Yourself 👾</h2>
        <p>If you somehow manage to break your own app... uh... well... that’s on you, pal 😅 But hey, it’s all part of the magic.</p>
    </div>

    <p style="font-size: 0.9rem; color: #999; margin-top: 2rem;">
        Last updated: May 2025 • Self-approved with snacks 🍪
    </p>
</div>

<div class="text-center mt-4 text-muted small">
    &copy; 2025 Memoir
</div>
@endsection
