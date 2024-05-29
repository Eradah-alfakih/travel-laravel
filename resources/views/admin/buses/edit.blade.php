@extends('admin.layouts.app')

@section('content')
<div class="mt-5">
    <h2>{{ isset($bus) ? 'Edit Bus' : 'Add Bus' }}</h2>
    <a href="{{ route('buses.index') }}" class="btn btn-secondary mb-3">Back</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($bus) ? route('buses.update', $bus->id) : route('buses.store') }}" method="POST">
        @csrf
        @if(isset($bus))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="bus_number">Bus Number:</label>
            <input type="text" name="bus_number" class="form-control" value="{{ isset($bus) ? $bus->bus_number : old('bus_number') }}">
        </div>

        <div class="form-group">
            <label for="registration_number">Registration Number:</label>
            <input type="text" name="registration_number" class="form-control" value="{{ isset($bus) ? $bus->registration_number : old('registration_number') }}">
        </div>

        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" name="make" class="form-control" value="{{ isset($bus) ? $bus->make : old('make') }}">
        </div>

        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" name="model" class="form-control" value="{{ isset($bus) ? $bus->model : old('model') }}">
        </div>

        <div class="form-group">
            <label for="year_of_manufacture">Year of Manufacture:</label>
            <input type="number" name="year_of_manufacture" class="form-control" value="{{ isset($bus) ? $bus->year_of_manufacture : old('year_of_manufacture') }}">
        </div>

        <div class="form-group">
            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" class="form-control" value="{{ isset($bus) ? $bus->capacity : old('capacity') }}">
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control">
                <option value="1" {{ isset($bus) && $bus->status == '1' ? 'selected' : '' }}>Active</option>
                <option value="-1" {{ isset($bus) && $bus->status == '-1' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
         <div class="form-group">
            <label for="driver_id">Driver:</label>
            <select name="driver_id" class="form-control">
                @foreach($drivers as $driver)
                
                    <option value="{{ $driver->id }}" {{ isset($bus) && $bus->driver_id == $driver->id ? 'selected' : '' }}>
                        {{ $driver->first_name }}   {{ $driver->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($bus) ? 'Update' : 'Save' }}</button>
    </form>
</div>
@endsection
