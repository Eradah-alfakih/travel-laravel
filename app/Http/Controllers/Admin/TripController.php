<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Governorate;
use App\Models\Bus;
use App\Models\Service;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::all();
        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        $governorates=Governorate::where('status',1)->get();
     $buses = Bus::where('status',1)->get();
        return view('admin.trips.create',compact('governorates','buses'));
    }

    public function store(Request $request)
{
    Validator::extend('after_one_hour', function ($attribute, $value, $parameters, $validator) {
        // Get the selected date and time
        $selectedDateTime = new \DateTime($value);
        
        // Get the current date and time
        $currentDateTime = new \DateTime();
        
        // Add one hour to the current date and time
        $currentDateTime->modify('+1 hour');
        
        // Convert both to timestamps
        $selectedTimestamp = $selectedDateTime->getTimestamp();
        $currentTimestamp = $currentDateTime->getTimestamp();
        
        // Check if the selected date and time is after one hour from the current date and time
        return $selectedTimestamp >= $currentTimestamp;
    });
    $validatedData = $request->validate([
        'from_governorate' => 'required|exists:governorates,id',
        'to_governorate' => 'required|exists:governorates,id',
        'bus_id' => 'required|exists:buses,id',
        'travel_date' => [
            'required',
            'date',
            'after_or_equal:today',
            'after_one_hour'
        ],
        'status' => 'required|string',
        'type' => 'required|string',
        'services' => 'required|array',
        'services.*.name' => 'required|string',
        'services.*.price' => 'required|numeric',
        'services.*.seat_service_number' => 'required|integer',
        'services.*.details' => 'nullable|string',
    ]);

    $bus = Bus::find($request->bus_id);
    $totalSeats = array_sum(array_column($request->services, 'seat_service_number'));

    if ($totalSeats > $bus->capacity) {
        return redirect()->back()->withInput()->withErrors(['total_seats' => 'The total available seats for services cannot exceed the bus capacity.']);
    }

    $trip = Trip::create([
        'from_governorate' => $request->input('from_governorate'),
        'to_governorate' => $request->input('to_governorate'),
        'bus_id' => $request->input('bus_id'),
        'travel_date' => $request->input('travel_date'),
        'status' => $request->input('status'),
        'type' => $request->input('type'),
    ]);

    foreach ($request->services as $service) {
        Service::create([
            'trip_id' => $trip->id,
            'name' => $service['name'],
            'price' => $service['price'],
            'seat_service_number' => $service['seat_service_number'],
            'details' => $service['details'],
        ]);
    }

    return redirect()->route('trips.index')->with('success', 'Trip created successfully.');
}
    

    // Implement other methods like show, edit, update, destroy
    public function edit($id)
    {
        $trip = Trip::with('services')->findOrFail($id);
        $trip->travel_date = new \DateTime($trip->travel_date); // Convert travel_date to DateTime object
        $buses = Bus::all();
        $governorates = Governorate::all();
        return view('admin.trips.edit', compact('trip', 'buses', 'governorates'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'from_governorate' => 'required|different:to_governorate',
            'to_governorate' => 'required',
            'travel_date' => 'required|date|after:today',
            'status' => 'required|in:New,Canceled,Completed',
            'type' => 'required|in:Seasonal,Daily',
            'bus_id' => 'required|exists:buses,id',
        ]);

        $trip = Trip::findOrFail($id);
        $trip->update($validatedData);

        $services = $request->validate([
            'services' => 'required|array',
            'services.*.id' => 'nullable|exists:services,id',
            'services.*.name' => 'required|string|max:255',
            'services.*.price' => 'required|numeric|min:0',
            'services.*.seat_service_number' => 'required|integer|min:0',
            'services.*.details' => 'nullable|string',
        ]);

        $existingServiceIds = $trip->services->pluck('id')->toArray();

        foreach ($services['services'] as $serviceData) {
            if (isset($serviceData['id'])) {
                $service = Service::findOrFail($serviceData['id']);
                $service->update($serviceData);
                $existingServiceIds = array_diff($existingServiceIds, [$service->id]);
            } else {
                $trip->services()->create($serviceData);
            }
        }
 
        // Remove services that were not in the request
        Service::destroy($existingServiceIds);

        return redirect()->route('trips.index')->with('success', 'Trip updated successfully.');
    }
    public function showReservations($tripId)
{
    $trip = Trip::with('reservations.traveler')->findOrFail($tripId);
    return view('admin.trips.reservations', compact('trip'));
}
public function getAvailableBuses(Request $request)
{
    $selectedDate = Carbon::parse($request->date)->format('Y-m-d');

    $availableBuses = Bus::whereDoesntHave('trips', function ($query) use ($selectedDate) {
        $query->whereDate('travel_date', '=', $selectedDate);
    })->get();

    return response()->json(['availableBuses' => $availableBuses]);
}
}