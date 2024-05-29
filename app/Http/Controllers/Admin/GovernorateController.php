<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    public function index()
    {
        $governorates = Governorate::all();
        return view('admin.governorates.index', compact('governorates'));
    }

    public function create()
    {
        return view('admin.governorates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Governorate::create($request->all());

        return redirect()->route('governorates.index')->with('success', 'Governorate created successfully.');
    }

    public function show($id)
    {
        $governorate = Governorate::findOrFail($id);
        return view('admin.governorates.show', compact('governorate'));
    }

    public function edit($id)
    {
        $governorate = Governorate::findOrFail($id);
        return view('admin.governorates.edit', compact('governorate'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $governorate = Governorate::findOrFail($id);
        $governorate->update($request->all());

        return redirect()->route('governorates.index')->with('success', 'Governorate updated successfully.');
    }

    public function destroy($id)
    {
        $governorate = Governorate::findOrFail($id);
        $governorate->update([
            'status'=>-1*$governorate->status
        ]);
        return redirect()->route('governorates.index')->with('success', 'Governorate deleted successfully.');
    }
}