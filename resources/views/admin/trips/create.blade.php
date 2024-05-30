@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Add Trip</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="from_governorate">From Governorate:</label>
            <select name="from_governorate" class="form-control" required>
                <option value="">Select From Governorate</option>
                @foreach($governorates as $governorate)
                    <option value="{{ $governorate->id }}" {{ old('from_governorate') == $governorate->id ? 'selected' : '' }}>{{ $governorate->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="to_governorate">To Governorate:</label>
            <select name="to_governorate" class="form-control" required>
                <option value="">Select To Governorate</option>
                @foreach($governorates as $governorate)
                    <option value="{{ $governorate->id }}" {{ old('to_governorate') == $governorate->id ? 'selected' : '' }}>{{ $governorate->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="travel_date">Travel Date:</label>
            <input type="datetime-local" name="travel_date" id="travel_date"class="form-control" value="{{ old('travel_date') }}" required>
        </div>
        <div class="form-group">
            <label for="bus_id">Bus:</label>
            <select name="bus_id" id="bus_id" class="form-control" required>
                <option value="">Select Bus</option>
                
            </select>
        </div>

        

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                
                <option value="New" {{ old('status') == 'New' ? 'selected' : '' }}>New</option>
                   </select>
        </div>

        <div class="form-group">
            <label for="type">Type:</label>
            <select name="type" class="form-control" required>
                <option value="">Select Type</option>
                <option value="Seasonal" {{ old('type') == 'Seasonal' ? 'selected' : '' }}>Seasonal</option>
                <option value="Daily" {{ old('type') == 'Daily' ? 'selected' : '' }}>Daily</option>
            </select>
        </div>

        <div class="mt-4">
            <h3>Services</h3>
            <div id="busCapacity" class="alert alert-info" style="display: none;"></div>

            <!-- Service fields -->
            <div id="services">
                @if(old('services'))
                    @foreach(old('services') as $index => $service)
                        <div class="service row">
                            <div class="form-group col-md-2">
                                <label for="services[{{ $index }}][name]">Service Name:</label>
                                <input type="text" name="services[{{ $index }}][name]" class="form-control" value="{{ $service['name'] }}" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="services[{{ $index }}][price]">Price:</label>
                                <input type="number" name="services[{{ $index }}][price]" class="form-control" value="{{ $service['price'] }}" required>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="services[{{ $index }}][seat_service_number]">Available Seats:</label>
                                <input type="number" name="services[{{ $index }}][seat_service_number]" class="form-control seat-service-number" value="{{ $service['seat_service_number'] }}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="services[{{ $index }}][details]">Details:</label>
                                <textarea name="services[{{ $index }}][details]" class="form-control" rows="3">{{ $service['details'] }}</textarea>
                            </div>

                            <div class="form-group col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-service">-</button>
                            </div>
                        </div>
                    @endforeach
                @else
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
                            <input type="number" name="services[0][seat_service_number]" class="form-control seat-service-number" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="services[0][details]">Details:</label>
                            <textarea name="services[0][details]" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-service">-</button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Add button -->
            <button type="button" class="btn btn-primary" id="addService">+</button>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
<script>
    $(document).ready(function() {
        $('#travel_date').change(function() {
            console.log("hi");
        var selectedDate = $(this).val();
        
        $.ajax({
            url: '{{ route("getAvailableBuses") }}',
            type: 'GET',
            data: {
                date: selectedDate
            },
            success: function(response) {
                // Update bus dropdown menu with available buses
                var busDropdown = $('#bus_id');
                busDropdown.empty();
                busDropdown.append($('<option>').text('Select Bus').attr('value', ''));
                $.each(response.availableBuses, function(key, value) {
                    busDropdown.append($('<option>').text(value.bus_number).attr('value', value.id));
                });
            }
        });
    });
        let busCapacity = 0;

        $('#bus_id').change(function() {
            busCapacity = parseInt($('#bus_id option:selected').data('capacity'));
            $('#busCapacity').text('Bus Capacity: ' + busCapacity).show();
            updateAvailableCapacity();
        });

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

        $('#services').on('click', '.remove-service', function() {
            if ($('.service').length > 1) {
                $(this).closest('.service').remove();
                updateAvailableCapacity();
            }
        });

        $('#services').on('input', '.seat-service-number', function() {
            updateAvailableCapacity();
        });

        function updateAvailableCapacity() {
            let totalSeats = 0;

            $('.seat-service-number').each(function() {
                totalSeats += parseInt($(this).val()) || 0;
            });

            if (totalSeats > busCapacity) {
                alert('The total available seats for services cannot exceed the bus capacity.');
            }
        }

        // Trigger change event to update bus capacity and available capacity
        if ($('#bus_id').val() !== '') {
            $('#bus_id').trigger('change');
        }

        // Update available capacity on page load if there are old inputs
        updateAvailableCapacity();
    });
</script>
@endsection
