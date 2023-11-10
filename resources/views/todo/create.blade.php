@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="justify-content-center">Todo Create Here</h2>

    <form action="/todo" method="post">
        @csrf

        <div class="mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control">
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="" class="form-control" rows="3"></textarea>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="due_date">Due date</label>
            <input type="date" name="due_date" id="due_date" class="form-control">
            @error('due_date')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <select name="status" class="form-select">
                <option value="pending">Pending</option>
                <option value="progress">Progress</option>
                <option value="completed">Completed</option>
            </select>
            @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
