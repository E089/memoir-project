@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Create a New Category</h2>

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Category</button>
    </form>
</div>
@endsection
