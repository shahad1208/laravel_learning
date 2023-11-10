@extends('layouts.app')
@section('content')

<div class="container">

    <div class="mt-5">
        <h2>Todo List</h2>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="mt-3 col-md-3">
            <label for="statusFilter" class="form-label">Filter by Status:</label>
            <select id="statusFilter" class="form-select" onchange="loadTodoData(this.value)">
                <option value="all" selected>All</option>
                <option value="pending">Pending</option>
                <option value="progress">Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div id="filteredTasksSection" style="display: none;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">S - R No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="filteredTasksTable"></tbody>
            </table>
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example" id="filteredPagination"></nav>
            </div>
        </div>
        <a href="todo/create" class="btn btn-primary btn-sm text-right position-absolute top-0 end-0 m-5">Create</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">S - R No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tasksTable">

            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                {{ $todo->links() }}
            </nav>
        </div>
    </div>
</div>

<!-- Modal for Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this TODO item?</p>
            </div>
            <div class="modal-footer">

                <!-- Form for Delete -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        loadTodoData();

        function loadTodoData(status = 'all') {
            $.ajax({
                type: 'GET',
                url: '{{ route('todo.index') }}',
                dataType: 'json',
                data: { status: status },
                success: function (data) {
                    $('#tasksTable').empty();
                    $.each(data.data.data, function (index, todo) {

                // Check if todo is not null or undefined and it has the 'id' property
                if (todo && todo.id !== undefined) {
                var row = '<tr>' +
                '<th scope="row">' + todo.id + '</th>' +
                '<td>' + (todo.title || '') + '</td>' +
                '<td>' + (todo.due_date || '') + '</td>' +
                '<td>' + (todo.status || '') + '</td>' +
                '<td>' +
                '<a href="{{ url('todo') }}/' + todo.id + '" class="btn btn-info show-todo" data-todo-id="' + todo.id + '">Show</a>' +
                '<a href="{{ url('todo') }}/' + todo.id + '/edit" class="btn btn-Secondary edit-todo" data-todo-id="' + todo.id + '">Edit</a>' +

                '<button class="btn btn-danger deleteRecord" data-bs-toggle="modal" data-bs-target="#deleteModal" data-todo-id="' + todo.id + '">Delete</button>' +

                '</td>' +
                '</tr>';

                $('#tasksTable').append(row);
                } else {
                console.error('Invalid or missing ID in TODO item:', todo);
        }
});
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Event listener for status filter change
        $('#statusFilter').change(function () {
            var selectedStatus = $(this).val();
            loadTodoData(selectedStatus);

            handleStatusChange(selectedStatus);
        });

        function handleStatusChange(status) {

            console.log('Selected status changed to:', status);
        }
    });

    $(document).ready(function () {
    $('.delete-todo').on('click', function () {
        var todoId = $(this).data('todo-id');


    });
});

// Event listener for delete button
$(document).ready(function () {
    $(document).on('click', '.deleteRecord', function () {
        var todoId = $(this).data('todo-id');

        $('#deleteModal').modal('show');

        $('#confirmDelete').data('todo-id', todoId);
    });

    $(document).on('click', '#confirmDelete', function () {
        var todoIdToDelete = $(this).data('todo-id');

        $.ajax({
            type: 'DELETE',
            url: '{{ url('todo') }}/' + todoIdToDelete,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function (response) {
                console.log(response.message);

                $('#deleteModal').modal('hide');

                location.reload();
            },
            error: function (error) {
                console.error('Error deleting todo item:', error);
            }
        });
    });
});



</script>


@endsection
