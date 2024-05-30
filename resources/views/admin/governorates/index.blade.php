@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Governorates</h2>

    <!-- Button to trigger modal for adding a governorate -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
        Add Governorate
    </button>

    <!-- Modal for adding a governorate -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Governorate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add governorate form -->
                    <form id="addForm" action="{{ route('governorates.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="-1">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="addForm" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table to display governorates -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($governorates as $governorate)
            <tr>
                <td>{{ $governorate->id }}</td>
                <td>{{ $governorate->name }}</td>
                 <td>{{$governorate->status  == 1 ? 'Active' : 'UnActive' }}</td>

                <td>
                    <!-- Button to trigger modal for editing a governorate -->
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $governorate->id }}">
                        Edit
                    </button>

                    <!-- Modal for editing a governorate -->
                    <div class="modal fade" id="editModal{{ $governorate->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $governorate->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $governorate->id }}">Edit Governorate</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Edit governorate form -->
                                    <form action="{{ route('governorates.update', $governorate->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name" class="form-control" value="{{ $governorate->name }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ $governorate->status == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="-1" {{ $governorate->status == '-1' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- JavaScript to handle modal submission -->
    <script>
        $('#addModal').on('shown.bs.modal', function () {
            $('#addForm').trigger('focus')
        })
    </script>
</div>
@endsection
