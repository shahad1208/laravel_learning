@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Task</h2>

    <form action="{{ route('todo.update', ['todo' => $todo]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $todo->title }}">
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="" class="form-control" rows="3">{{  $todo->description}}</textarea>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $todo->due_date }}">
            @error('due_date')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="pending" {{ $todo->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="progress" {{ $todo->status === 'progress' ? 'selected' : '' }}>Progress</option>
                <option value="completed" {{ $todo->status === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>

            @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>
</div>
@endsection
