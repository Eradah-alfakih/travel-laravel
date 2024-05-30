<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use App\Models\Traveler;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['trip.fromGovernorate', 'trip.toGovernorate', 'service', 'traveler'])->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $trips = Trip::with('services')->get();
        $travelers = User::get(); // Assuming travelers are stored in the users table

        return view('admin.reservations.create', compact('trips', 'travelers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'service_id' => 'required|exists:services,id',
            'seat_number' => 'required|integer',
            'reservation_date' => 'required|date',
            'total' => 'required|numeric',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'gender' => 'required',
            'file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'id_number' => $request->input('id_number'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
        ];
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('travelers_files', 'public');
        }
        $traveler=Traveler::create($data);
        $reservation =Reservation::create([
            'trip_id' => $request->input('trip_id'),
            'service_id' => $request->input('service_id'),
            'seat_number' => $request->input('seat_number'),
            'reservation_date' => $request->input('reservation_date'),
            'total' => $request->input('total'),
            'traveler_id' => $traveler->id,
        ]);
         
  
        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully.');
    }

    public function edit($id)
{
    $reservation = Reservation::findOrFail($id);
    $traveler = $reservation->traveler;
    $trips = Trip::with('fromGovernorate', 'toGovernorate', 'services')->get();
    
    // Fetch the services for the current trip
    $services = $reservation->trip->services;

    return view('admin.reservations.edit', compact('reservation', 'traveler', 'trips', 'services'));
}


    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'trip_id' => 'required|exists:trips,id',
        'seat_number' => 'required|integer',
        'reservation_date' => 'required|date',
        'total' => 'required|integer',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'id_number' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
    ]);

    $reservation = Reservation::findOrFail($id);
    $reservation->update([
        'trip_id' => $request->input('trip_id'),
        'service_id' => $request->input('service_id'),
        'seat_number' => $request->input('seat_number'),
        'reservation_date' => $request->input('reservation_date'),
        'total' => $request->input('total'),
    ]);

    $traveler = $reservation->traveler;
    $traveler->update([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'id_number' => $request->input('id_number'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'gender' => $request->input('gender'),
    ]);

    return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
}


    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->traveler->delete();
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}