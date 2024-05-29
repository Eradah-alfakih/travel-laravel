@extends('admin.layouts.app')

@section('content')
<div class="mt-5">
    <h2>Bus Management</h2>
    <a href="{{ route('buses.create') }}" class="btn btn-primary mb-3">Add Bus</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Bus Number</th>
            <th>Registration Number</th>
            <th>Make</th>
            <th>Model</th>
            <th>Year of Manufacture</th>
            <th>Capacity</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($buses as $bus)
            <tr>
                <td>{{ $bus->id }}</td>
                <td>{{ $bus->bus_number }}</td>
                <td>{{ $bus->registration_number }}</td>
                <td>{{ $bus->make }}</td>
                <td>{{ $bus->model }}</td>
                <td>{{ $bus->year_of_manufacture }}</td>
                <td>{{ $bus->capacity }}</td>
                <td>{{ $bus->status }}</td>
                <td>
                    <form action="{{ route('buses.destroy', $bus->id) }}" method="POST">
                        {{-- <a class="btn btn-info" href="{{ route('buses.show', $bus->id) }}">Show</a> --}}
                        <a class="btn btn-primary" href="{{ route('buses.edit', $bus->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
