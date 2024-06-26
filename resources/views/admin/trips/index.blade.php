@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Trips</h2>

    <a href="{{ route('trips.create') }}" class="btn btn-primary mb-3">Add Trip</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>From Governorate</th>
                <th>To Governorate</th>
                <th>Travel Date</th>
                <th>Status</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
            <tr>
                <td>{{ $trip->id }}</td>
                <td>{{ $trip->fromGovernorate->name }}</td>
                <td>{{ $trip->toGovernorate->name }}</td>
                <td>{{ $trip->travel_date }}</td>
                <td>{{ $trip->status }}</td>
                <td>{{ $trip->type }}</td>
                <td>
                    <a href="{{ route('trips.edit', $trip->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <a href="{{ route('trips.reservations', $trip->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-info-circle"></i> Details
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
