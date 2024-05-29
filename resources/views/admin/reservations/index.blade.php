@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Trips</h2>

    <!-- Button to trigger modal for adding a trip -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
        Add Trip
    </button>

    <!-- Table to display trips -->
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bus ID</th>
                <th>From Governorate</th>
                <th>To Governorate</th>
                <th>Travel Date</th>
                <th>Status</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
            <tr>
                <td>{{ $trip->id }}</td>
                <td>{{ $trip->bus_id }}</td>
                <td>{{ $trip->fromGovernorate->name }}</td>
                <td>{{ $trip->toGovernorate->name }}</td>
                <td>{{ $trip->travel_date }}</td>
                <td>{{ $trip->status }}</td>
                <td>{{ $trip->type }}</td>
                <td>
                    <!-- Button to trigger modal for editing a trip -->
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $trip->id }}">
                        Edit
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal for adding a trip -->
    @include('admin.trips.partials.add_modal', ['governorates' => $governorates])

    <!-- Include modals for editing each trip -->
    @foreach($trips as $trip)
        @include('admin.trips.partials.edit_modal', ['trip' => $trip, 'governorates' => $governorates])
    @endforeach
</div>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    // Ensure that addForm and editForm submissions are handled correctly
    $('#addModal').on('shown.bs.modal', function () {
        $('#addForm').trigger('focus')
    });
</script>
@endsection
