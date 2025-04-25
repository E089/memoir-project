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

    .memoir-header {
        font-family: 'Schoolbell', cursive;
        font-size: 3rem;
        color: #333;
        text-align: center;
        margin-bottom: 0.2rem;
    }

    .memoir-sub {
        font-family: 'Inter', sans-serif;
        text-align: center;
        font-size: 1rem;
        color: #777;
        margin-bottom: 2rem;
    }

    .card {
        background-color: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        max-width: 900px;
        width: 120%;
        margin-right: -10px;
        
    }

    input.form-control {
        border-radius: 12px;
        padding: 0.75rem;
    }

    body.dark-mode {
        background-color: #121212;
    }

    body.dark-mode .card {
        background-color: #1e1e1e;
        color: white;
    }

    body.dark-mode input.form-control {
        background-color: #333;
        color: white;
        border: none;
    }

    body.dark-mode .memoir-header,
    body.dark-mode .memoir-sub,
    body.dark-mode .text-muted,
    body.dark-mode .text-muted a,
    body.dark-mode .form-label {
        color: white !important;
    }

    body.dark-mode .btn-dark {
        background-color: white;
        color: black;
        border: none;
    }

    body.dark-mode .btn-dark:hover {
        background-color: #e0e0e0;
    }

    .toggle-mode {
        position: absolute;
        top: 1rem;
        right: 1rem;
        cursor: pointer;
        font-size: 0.9rem;
        color: #666;
    }

    .form-error {
    font-size: 0.85rem;
    color: #ff4d4f;
    margin-top: 0.25rem;
    margin-left: 0.25rem;
    font-weight: 500;
    }

    body.dark-mode .form-error {    
    color: #ff7a7a;
    text-shadow: 0 0 4px rgba(255, 122, 122, 0.6);
    }

</style>

<div class="toggle-mode" onclick="toggleDarkMode()">🌓 Toggle</div>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card">
            <div class="memoir-header">Welcome to Memoir</div>
            <div class="memoir-sub">Your thoughts belong here.</div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark w-100 rounded-pill">Create Account</button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Already have an account?</small><br>
                <a href="{{ route('login') }}" class="text-decoration-none" style="font-weight: 500;">Login</a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
    }
</script>
@endsection