@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Reservations for Trip: {{ $trip->fromGovernorate->name }} to {{ $trip->toGovernorate->name }}</h2>

    <table class="table">
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
                <th>File</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
             @foreach($trip->reservations as $reservation)
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

                     <a href="{{ asset('storage/' . $reservation->traveler->file) }}" target="_blank">View current Id</a>
                 </td>
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
