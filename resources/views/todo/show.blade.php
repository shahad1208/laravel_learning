@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Task Details</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title" style="{{ ($todo->status != 'completed' && now() > $todo->due_date) ? 'color: red;' : 'color: green;' }}">{{ $todo->title }}</h5>
            <p class="card-text"><strong>Description:</strong> {{ $todo->description }}</p>
            <p class="card-text"><strong>Due Date:</strong> {{ $todo->due_date }}</p>
            <p class="card-text" style="{{ ($todo->status != 'completed' && now() > $todo->due_date) ? 'color: red;' : 'color: green;' }}"><strong>Status:</strong> {{ $todo->status }}</p>
        </div>
    </div>
</div>
@endsection
