<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Governorate;
use App\Models\Bus;
use App\Models\Service;

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
        $validatedData = $request->validate([
            'from_governorate' => 'required|different:to_governorate', // Ensure 'from_governorate' is different from 'to_governorate'
            'to_governorate' => 'required',
            'travel_date' => 'required|date',
            'status' => 'required|in:New,Canceled,Completed', // Ensure 'status' is one of the specified values
            'type' => 'required|in:Seasonal,Daily', // Ensure 'type' is one of the specified values
            'bus_id' => 'required|exists:buses,id',
        ]);
    
        $trip = Trip::create($validatedData);
    
        // Validate and create services
        $services = $request->validate([
            'services' => 'required|array',
            'services.*.name' => 'required|string|max:255',
            'services.*.price' => 'required|numeric|min:0',
            'services.*.seat_service_number' => 'required|integer|min:0',
            'services.*.details' => 'nullable|string',
        ]);
    
        foreach ($services['services'] as $service) {
            $trip->services()->create($service);
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
            'travel_date' => 'required|date',
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
}