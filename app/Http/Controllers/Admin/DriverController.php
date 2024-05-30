<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|unique:drivers|string|max:255',
            'phone' => 'required|unique:drivers',
            'email' => 'required|unique:drivers|string|email|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => ['required', 'date', function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->age < 18) {
                    $fail('The ' . $attribute . ' must indicate an age of at least 18 years.');
                }
            }],
            'hire_date' => 'required|date',
            'status' => 'required|string|max:255',
            'license' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Add validation rule for the license
        ]);

        $data = $request->all();

        if ($request->hasFile('license')) {
            $data['license'] = $request->file('license')->store('licenses', 'public');
        }

        Driver::create($data);

        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'phone' => 'required|unique:drivers,phone,' . $id,
            'email' => 'required|string|email|max:255|unique:drivers,email,' . $id,
            'address' => 'required|string|max:255',
            'date_of_birth' => ['required', 'date', function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->age < 18) {
                    $fail('The ' . $attribute . ' must indicate an age of at least 18 years.');
                }
            }],
            'hire_date' => 'required|date',
            'status' => 'required|string|max:255',
            'license' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Add validation rule for the license
        ]);

        $driver = Driver::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('license')) {
            // Delete old file if exists
            if ($driver->license) {
                \Storage::disk('public')->delete($driver->license);
            }
            $data['license'] = $request->file('license')->store('licenses', 'public');
        }

        $driver->update($data);

        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();
        // $driver->update([
        //     'status' => -1 * $driver->status
        // ]);
        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully.');
    }
}

?>