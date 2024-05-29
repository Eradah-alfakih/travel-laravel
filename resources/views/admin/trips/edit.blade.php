@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Trip</h2>

    <form action="{{ route('trips.update', $trip->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="from_governorate">From Governorate:</label>
            <select name="from_governorate" class="form-control" required>
                <option value="">Select From Governorate</option>
                @foreach($governorates as $governorate)
                    <option value="{{ $governorate->id }}" {{ $trip->from_governorate == $governorate->id ? 'selected' : '' }}>
                        {{ $governorate->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="to_governorate">To Governorate:</label>
            <select name="to_governorate" class="form-control" required>
                <option value="">Select To Governorate</option>
                @foreach($governorates as $governorate)
                    <option value="{{ $governorate->id }}" {{ $trip->to_governorate == $governorate->id ? 'selected' : '' }}>
                        {{ $governorate->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="travel_date">Travel Date:</label>
            <input type="datetime-local" name="travel_date" class="form-control" value="{{ $trip->travel_date->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                <option value="New" {{ $trip->status == 'New' ? 'selected' : '' }}>New</option>
                <option value="Canceled" {{ $trip->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                <option value="Completed" {{ $trip->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="type">Type:</label>
            <select name="type" class="form-control" required>
                <option value="Seasonal" {{ $trip->type == 'Seasonal' ? 'selected' : '' }}>Seasonal</option>
                <option value="Daily" {{ $trip->type == 'Daily' ? 'selected' : '' }}>Daily</option>
            </select>
        </div>

        <div class="form-group">
            <label for="bus_id">Bus:</label>
            <select name="bus_id" class="form-control" required>
                <option value="">Select Bus</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}" {{ $trip->bus_id == $bus->id ? 'selected' : '' }}>
                        {{ $bus->bus_number }} - {{ $bus->registration_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <h3>Services</h3>

            <div id="services">
                @foreach($trip->services as $index => $service)
                    <div class="service row">
                        <input type="hidden" name="services[{{ $index }}][id]" value="{{ $service->id }}">

                        <div class="form-group col-md-2">
                            <label for="services[{{ $index }}][name]">Service Name:</label>
                            <input type="text" name="services[{{ $index }}][name]" class="form-control" value="{{ $service->name }}" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="services[{{ $index }}][price]">Price:</label>
                            <input type="number" name="services[{{ $index }}][price]" class="form-control" value="{{ $service->price }}" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="services[{{ $index }}][seat_service_number]">Available Seats:</label>
                            <input type="number" name="services[{{ $index }}][seat_service_number]" class="form-control" value="{{ $service->seat_service_number }}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="services[{{ $index }}][details]">Details:</label>
                            <textarea name="services[{{ $index }}][details]" class="form-control" rows="3">{{ $service->details }}</textarea>
                        </div>

                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-service">-</button>
                        </div>
                    </div>
                @endforeach
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
        var serviceCount = {{ $trip->services->count() }};

        // Add service button functionality
        $('#addService').click(function() {
            var newService = $('.service').first().clone();

            newService.find(':input').each(function() {
                var newName = this.name.replace(/\d+/, serviceCount);
                this.name = newName;
                this.value = '';
            });

            $('#services').append(newService);
            serviceCount++;
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
