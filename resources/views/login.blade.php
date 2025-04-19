@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Schoolbell&family=Inter:wght@300;400;600&display=swap');

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
    body.dark-mode .text-muted a {
        color: white !important;
    }

    body.dark-mode .btn-dark {
        background-color: white;
        color: #333;
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
</style>

<div class="toggle-mode" onclick="toggleDarkMode()">🌓 Toggle</div>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card">
            <div class="memoir-header">Welcome Back</div>
            <div class="memoir-sub">Ready to continue your story?</div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Display error messages if they exist -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-dark w-100 rounded-pill">Login</button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Don't have an account?</small><br>
                <a href="{{ route('register') }}" class="text-decoration-none" style="font-weight: 500;">Register here</a>
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
