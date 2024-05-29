@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Add Trip</h2>

    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="from_governorate">From Governorate:</label>
            <select name="from_governorate" class="form-control" required>
                <option value="">Select From Governorate</option>
                @foreach($governorates as $governorate)
                    <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="to_governorate">To Governorate:</label>
            <select name="to_governorate" class="form-control" required>
                <option value="">Select To Governorate</option>
                @foreach($governorates as $governorate)
                    <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bus_id">Bus:</label>
            <select name="bus_id" class="form-control" required>
                <option value="">Select Bus</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}">{{ $bus->bus_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="travel_date">Travel Date:</label>
            <input type="datetime-local" name="travel_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                <option value="">Select Status</option>
                <option value="New">New</option>
                <option value="Canceled">Canceled</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="type">Type:</label>
            <select name="type" class="form-control" required>
                <option value="">Select Type</option>
                <option value="Seasonal">Seasonal</option>
                <option value="Daily">Daily</option>
            </select>
        </div>

        <div class="mt-4">
            <h3>Services</h3>

            <!-- Service fields -->
            <div id="services">
                <div class="service row">
                    <div class="form-group col-md-2">
                        <label for="services[0][name]">Service Name:</label>
                        <input type="text" name="services[0][name]" class="form-control" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="services[0][price]">Price:</label>
                        <input type="number" name="services[0][price]" class="form-control" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="services[0][seat_service_number]">Available Seats:</label>
                        <input type="number" name="services[0][seat_service_number]" class="form-control" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="services[0][details]">Details:</label>
                        <textarea name="services[0][details]" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-service">-</button>
                    </div>
                </div>
            </div>

            <!-- Add button -->
            <button type="button" class="btn btn-primary" id="addService">+</button>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</div>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Add service button functionality
        $('#addService').click(function() {
            var serviceCount = $('.service').length;
            var newService = $('.service').first().clone();

            newService.find(':input').each(function() {
                var newName = this.name.replace(/\d+/, serviceCount);
                this.name = newName;
                this.value = '';
            });

            $('#services').append(newService);
        });

        // Remove service button functionality
        $('#services').on('click', '.remove-service', function() {
            if ($('.service').length > 1) {
                $(this).closest('.service').remove();
            }
        });
    });
</script>
@endsection
