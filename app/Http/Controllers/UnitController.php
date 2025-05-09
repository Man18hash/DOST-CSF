<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitProvider;
use App\Models\Office;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UnitController extends Controller
{
    /**
     * Display the Units page.
     */
    public function index()
    {
        // match the Blade’s $unitProviders and $offices variables
        $unitProviders = UnitProvider::with('office')->get();
        $offices       = Office::all();

        return view('admin.units', compact('unitProviders', 'offices'));
    }

    /**
     * Store a newly created unit.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_name' => 'required|string|max:255',
            'office_id' => 'required|exists:offices,id',
        ]);

        UnitProvider::create([
            'unit_name' => $data['unit_name'],
            'office_id' => $data['office_id'],
            'status'    => 'Active',
        ]);

        return redirect()
            ->route('admin.units')
            ->with('success', 'New unit created successfully.');
    }

    /**
     * Update an existing unit.
     */
    public function update(Request $request, UnitProvider $unit)
    {
        $data = $request->validate([
            'unit_name' => 'required|string|max:255',
            'office_id' => 'required|exists:offices,id',
        ]);

        $unit->update([
            'unit_name' => $data['unit_name'],
            'office_id' => $data['office_id'],
        ]);

        return redirect()
            ->route('admin.units')
            ->with('success', 'Unit updated successfully.');
    }

    /**
     * Toggle Active/Inactive status for a unit (AJAX).
     */
    public function toggleStatus(UnitProvider $unit)
    {
        $unit->status = $unit->status === 'Active' ? 'Inactive' : 'Active';
        $unit->save();

        return response()->json([
            'success' => true,
            'status'  => $unit->status,
        ]);
    }
}
