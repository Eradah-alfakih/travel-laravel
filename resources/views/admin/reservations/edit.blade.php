@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Reservation</h2>

    <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="trip_id">Trip:</label>
            <select name="trip_id" class="form-control" required>
                <option value="">Select Trip</option>
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}" {{ $reservation->trip_id == $trip->id ? 'selected' : '' }}>
                        {{ $trip->fromGovernorate->name }} to {{ $trip->toGovernorate->name }} on {{ $trip->travel_date }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <label for="seat_number">Seat Number:</label>
            <input type="number" name="seat_number" class="form-control" value="{{ $reservation->seat_number }}" required>
        </div>

        <div class="form-group">
            <label for="reservation_date">Reservation Date:</label>
            <input type="date" name="reservation_date" class="form-control" value="{{ $reservation->reservation_date }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <input type="number" name="status" class="form-control" value="{{ $reservation->status }}" required>
        </div>

        <div class="form-group">
            <label for="total">Total:</label>
            <input type="number" name="total" class="form-control" value="{{ $reservation->total }}" required>
        </div>

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" class="form-control" value="{{ $reservation->first_name }}" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" class="form-control" value="{{ $reservation->last_name }}" required>
        </div>

        <div class="form-group">
            <label for="id_number">ID Number:</label>
            <input type="text" name="id_number" class="form-control" value="{{ $reservation->id_number }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" class="form-control" value="{{ $reservation->phone }}" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" class="form-control" value="{{ $reservation->address }}" required>
        </div>

      

        <div class="form-group">
            <label for="gender">Gender:</label>
            <input type="text" name="gender" class="form-control" value="{{ $reservation->gender }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
