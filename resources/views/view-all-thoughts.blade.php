@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4">Your Thoughts</h2>

    <!-- If there are entries -->
    @if($entries->count())
        <div class="list-group">
            @foreach ($entries as $entry)
                <div class="d-flex justify-content-between mb-3">
                    <!-- Entry Box (Clickable) -->
                    <a href="{{ route('entries.show', $entry->id) }}" class="list-group-item list-group-item-action flex-column align-items-start w-100">
                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <h5 class="mb-1">{{ $entry->title }}</h5>
                                <p class="mb-1">{{ Str::limit($entry->body, 100) }}</p>
                            </div>
                            <!-- Date on the right -->
                            <div>
                                <small>{{ $entry->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Delete Button Outside the Box -->
                    <form action="{{ route('delete-entry', $entry->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" title="Delete Entry">
                            <i class="fas fa-trash"></i> <!-- Font Awesome trash icon -->
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            You haven't written any entries yet. Start writing your first thought!
        </div>
    @endif

</div>

@endsection

<!-- Add some style for the delete button -->
@section('styles')
    <style>
        .btn-delete {
            background: none;
            border: none;
            color: red;
            cursor: pointer;
            font-size: 18px;
            margin-top: 10px;
        }

        .btn-delete:hover {
            color: darkred;
        }

        .fas.fa-trash {
            margin-right: 5px;
        }
    </style>
@endsection
