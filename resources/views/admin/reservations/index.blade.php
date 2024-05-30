@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Reservations List</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('reservations.create') }}" class="btn btn-primary">Create New Reservation</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Trip</th>
                <th>Service</th>
                <th>Seat Number</th>
                <th>Reservation Date</th>
                <th>Total</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>ID Number</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->trip->fromGovernorate->name }} to {{ $reservation->trip->toGovernorate->name }} on {{ $reservation->trip->travel_date }}</td>
                    <td>{{ $reservation->service->name }}</td>
                    <td>{{ $reservation->seat_number }}</td>
                    <td>{{ $reservation->reservation_date }}</td>
                    <td>{{ $reservation->total }}</td>
                    <td>{{ $reservation->traveler->first_name }}</td>
                    <td>{{ $reservation->traveler->last_name }}</td>
                    <td>{{ $reservation->traveler->id_number }}</td>
                    <td>{{ $reservation->traveler->phone }}</td>
                    <td>{{ $reservation->traveler->address }}</td>
                    <td>{{ $reservation->traveler->gender == 1 ? 'Male' : 'Female' }}</td>
                    <td>
                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
