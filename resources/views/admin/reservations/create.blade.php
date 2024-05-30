@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Create Reservation</h2>

    <form action="{{ route('reservations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="trip-info">
            <h3>Trip Information</h3>

            <div class="form-group">
                <label for="trip_id">Trip:</label>
                <select name="trip_id" class="form-control" required onchange="updateServices()">
                    <option value="">Select Trip</option>
                    @foreach($trips as $trip)
                        <option value="{{ $trip->id }}">{{ $trip->fromGovernorate->name }} to {{ $trip->toGovernorate->name }} on {{ $trip->travel_date }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="service_id">Service:</label>
                <select name="service_id" id="service_id" class="form-control" onchange="updateTotalAndDetails()" required>
                    <option value="">Select Service</option>
                </select>
            </div>

            <div class="form-group">
                <label for="seat_number">Seat Number:</label>
                <input type="number" name="seat_number" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="reservation_date">Reservation Date:</label>
                <input type="date" name="reservation_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="total">Total:</label>
                <input type="number" name="total" id="total" class="form-control" readonly required>
            </div>

            <div class="form-group">
                <label for="service_details">Service Details:</label>
                <input type="text" name="service_details" id="service_details" class="form-control" readonly>
            </div>
        </div>

        <div class="traveler-info">
            <h3>Traveler Information</h3>

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="id_number">ID Number:</label>
                <input type="text" name="id_number" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" name="gender" aria-label="Default select example">
                     <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>           
            </div>

            <div class="form-group">
                <label for="file">Upload ID or Passport:</label>
                <input type="file" name="file" class="form-control" required>
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

    // Add new options with price and details data attributes
    services.forEach(service => {
        var option = document.createElement('option');
        option.value = service.id;
        option.text = service.name;
        option.setAttribute('data-price', service.price); // Set data attribute for price
        option.setAttribute('data-details', service.details); // Set data attribute for details
        serviceSelect.appendChild(option);
    });
}

function updateTotalAndDetails() {
    var serviceSelect = document.querySelector('select[name="service_id"]');
    var totalInput = document.getElementById('total');
    var detailsInput = document.getElementById('service_details');
    var selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    var servicePrice = selectedOption.getAttribute('data-price');
    var serviceDetails = selectedOption.getAttribute('data-details');
    totalInput.value = servicePrice;
    detailsInput.value = serviceDetails;
}
</script>
@endsection
