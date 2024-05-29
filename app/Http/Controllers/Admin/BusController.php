<?php
namespace App\Http\Controllers\Admin;

use App\Models\Bus;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        $drivers = Driver::all();
    return view('admin.buses.edit', compact('drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_number' => 'required|unique:buses',
            'registration_number' => 'required|unique:buses',
            'make' => 'required',
            'model' => 'required',
            'year_of_manufacture' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        Bus::create($request->all());

        return redirect()->route('buses.index')->with('success', 'Bus created successfully.');
    }

    public function show(Bus $bus)
    {
        return view('admin.buses.show', compact('bus'));
    }

    public function edit(Bus $bus)
    {
        $bus = Bus::findOrFail($bus->id);
        $drivers = Driver::all();
        return view('admin.buses.edit', compact('bus', 'drivers'));
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'bus_number' => 'required|unique:buses,bus_number,' . $bus->id,
            'registration_number' => 'required|unique:buses,registration_number,' . $bus->id,
            'make' => 'required',
            'model' => 'required',
            'year_of_manufacture' => 'required|integer',
            'capacity' => 'required|integer',
            'status' => 'required',
        ]);

        $bus->update($request->all());
         return redirect()->route('buses.index')->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        // $bus->delete();
        $bus->update([
            'status'=>-1*$bus->status
        ]);

        return redirect()->route('buses.index')->with('success', 'Bus deleted successfully.');
    }
}
?>