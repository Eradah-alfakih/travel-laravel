@extends('admin.layouts.app')

@section('content')
<div class="mt-5">
    <h2>Drivers</h2>
    <a href="{{ route('drivers.create') }}" class="btn btn-primary mb-3">Add Driver</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>ID Number</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Hire Date</th>
                <th>Status</th>
                <th>License</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drivers as $driver)
                <tr>
                    <td>{{ $driver->first_name }}</td>
                    <td>{{ $driver->last_name }}</td>
                    <td>{{ $driver->id_number }}</td>
                    <td>{{ $driver->phone }}</td>
                    <td>{{ $driver->email }}</td>
                    <td>{{ $driver->address }}</td>
                    <td>{{ $driver->date_of_birth }}</td>
                    <td>{{ $driver->hire_date }}</td>
                    <td>{{ $driver->status }}</td>
                    <td>

                        @if (isset($driver) && $driver->license)
                        <a href="{{ asset('storage/' . $driver->license) }}" target="_blank">View current license</a>
                    @endif
                    </td>
                    <td>
                        <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
