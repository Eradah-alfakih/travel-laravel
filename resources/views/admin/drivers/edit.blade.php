@extends('admin.layouts.app')

@section('content')
<div class="mt-5">
    <h2>{{ isset($driver) ? 'Edit Driver' : 'Create Driver' }}</h2>
    <a href="{{ route('drivers.index') }}" class="btn btn-secondary mb-3">Back</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ isset($driver) ? route('drivers.update', $driver->id) : route('drivers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($driver))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" class="form-control" value="{{ isset($driver) ? $driver->first_name : old('first_name') }}">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" class="form-control" value="{{ isset($driver) ? $driver->last_name : old('last_name') }}">
        </div>

        <div class="form-group">
            <label for="id_number">ID Number:</label>
            <input type="text" name="id_number" class="form-control" value="{{ isset($driver) ? $driver->id_number : old('id_number') }}">
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="number" name="phone" class="form-control" value="{{ isset($driver) ? $driver->phone : old('phone') }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ isset($driver) ? $driver->email : old('email') }}">
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" class="form-control" value="{{ isset($driver) ? $driver->address : old('address') }}">
        </div>

        <div class="form-group">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ isset($driver) ? $driver->date_of_birth : old('date_of_birth') }}">
        </div>

        <div class="form-group">
            <label for="hire_date">Hire Date:</label>
            <input type="date" name="hire_date" class="form-control" value="{{ isset($driver) ? $driver->hire_date : old('hire_date') }}">
        </div>

        <div class="form-group">
            <label for="license">License:</label>
            <input type="file" name="license" class="form-control" value="{{ old('license') }}">
            @if (isset($driver) && $driver->license)
                <a href="{{ asset('storage/' . $driver->license) }}" target="_blank">View current license</a>
            @endif
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control">
                <option value="1" {{ isset($driver) && $driver->status == '1' ? 'selected' : '' }}>Active</option>
                <option value="-1" {{ isset($driver) && $driver->status == '-1' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($driver) ? 'Update' : 'Save' }}</button>
    </form>
</div>
@endsection
