<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $trips = Trip::all();
        $travelers = User::all(); // Assuming travelers are stored in the users table
        return view('admin.reservations.create', compact('trips', 'travelers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'traveler_id' => 'required|exists:users,id',
            'seat_number' => 'required|integer',
            'reservation_date' => 'required|date',
            'status' => 'required|integer',
            'total' => 'required|integer',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:255',
        ]);

        $reservation = Reservation::create($validatedData);

        return redirect()->route('admin.reservations.index')->with('success', 'Reservation created successfully.');
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $trips = Trip::all();
        $travelers = User::all();
        return view('admin.reservations.edit', compact('reservation', 'trips', 'travelers'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validatedData = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'traveler_id' => 'required|exists:users,id',
            'seat_number' => 'required|integer',
            'reservation_date' => 'required|date',
            'status' => 'required|integer',
            'total' => 'required|integer',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:255',
        ]);

        $reservation->update($validatedData);

        return redirect()->route('admin.reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}