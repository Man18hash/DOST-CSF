<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OfficeController extends Controller
{
    /**
     * Show list of offices.
     */
    public function index()
    {
        $offices = Office::all();
        return view('admin.offices', compact('offices'));
    }

    /**
     * Show form to create a new office.
     */
    public function create()
    {
        return view('admin.create_office');
    }

    /**
     * Store new office.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:offices,name|max:255',
        ]);

        Office::create([
            'name'   => $request->name,
            'status' => 'Active',
        ]);

        return redirect()
            ->route('admin.offices')
            ->with('success', 'New office created successfully!');
    }

    /**
     * Show form to edit an existing office.
     */
    public function edit(Office $office)
    {
        return view('admin.edit_office', compact('office'));
    }

    /**
     * Update an existing office.
     */
    public function update(Request $request, Office $office)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:offices,name,{$office->id}",
        ]);

        $office->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.offices')
            ->with('success', 'Office updated successfully!');
    }

    /**
     * Delete an office.
     */
    public function destroy(Office $office)
    {
        $office->delete();

        return back()->with('success', 'Office deleted successfully!');
    }

    /**
     * Toggle Active/Inactive status via AJAX.
     */
    public function toggleStatus(Office $office)
    {
        $office->status = $office->status === 'Active' ? 'Inactive' : 'Active';
        $office->save();

        return response()->json([
            'success' => true,
            'status'  => $office->status,
        ]);
    }
}
