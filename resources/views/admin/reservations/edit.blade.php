@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Reservation</h2>

    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="trip-info">
            <h3>Trip Information</h3>

            <div class="form-group">
                <label for="trip_id">Trip:</label>
                <select name="trip_id" class="form-control" required onchange="updateServices()">
                    <option value="">Select Trip</option>
                    @foreach($trips as $trip)
                        <option value="{{ $trip->id }}" {{ $reservation->trip_id == $trip->id ? 'selected' : '' }}>
                            {{ $trip->fromGovernorate->name }} to {{ $trip->toGovernorate->name }} on {{ $trip->travel_date }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="service_id">Service:</label>
                <select name="service_id" id="service_id" class="form-control" onchange="updateTotal()" required>
                    <option value="">Select Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}" {{ $reservation->service_id == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
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
                <label for="total">Total:</label>
                <input type="number" name="total" id="total" class="form-control" value="{{ $reservation->total }}" readonly required>
            </div>
        </div>

        <div class="traveler-info">
            <h3>Traveler Information</h3>

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" class="form-control" value="{{ $traveler->first_name }}" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" class="form-control" value="{{ $traveler->last_name }}" required>
            </div>

            <div class="form-group">
                <label for="id_number">ID Number:</label>
                <input type="text" name="id_number" class="form-control" value="{{ $traveler->id_number }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" class="form-control" value="{{ $traveler->phone }}" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" class="form-control" value="{{ $traveler->address }}" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" name="gender" aria-label="Default select example">
                    <option value="1" {{ $traveler->gender == 1 ? 'selected' : '' }}>Male</option>
                    <option value="2" {{ $traveler->gender == 2 ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>
function updateServices() {
    var tripSelect = document.querySelector('select[name="trip_id"]');
    var serviceSelect = document.getElementById('service_id');
    var selectedTripId = tripSelect.value;
    var selectedTrip = @json($trips); // Convert PHP array to JSON
    var services = selectedTrip.find(trip => trip.id == selectedTripId).services;

    // Clear existing options
    serviceSelect.innerHTML = '<option value="">Select Service</option>';

    // Add new options with price data attribute
    services.forEach(service => {
        var option = document.createElement('option');
        option.value = service.id;
        option.text = service.name;
        option.setAttribute('data-price', service.price); // Set data attribute for price
        serviceSelect.appendChild(option);
    });
}

function updateTotal() {
    var serviceSelect = document.querySelector('select[name="service_id"]');
    var totalInput = document.getElementById('total');
    var selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    var servicePrice = selectedOption.getAttribute('data-price');
    totalInput.value = servicePrice;
}
</script>
@endsection
