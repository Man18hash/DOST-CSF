<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DOSTEmployee;
use App\Models\Office;
use App\Models\UnitProvider;

class EmployeeController extends Controller
{
    /** Display Employees page */
    public function index()
    {
        $employees     = DOSTEmployee::with('unitProvider.office')->get();
        $offices       = Office::all();
        $unitProviders = UnitProvider::with('office')->get();

        return view('admin.employees', compact('employees', 'offices', 'unitProviders'));
    }

    /** Store a new Employee */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'employee_id'      => 'required|string|max:255|unique:dost_employees,employee_id',
            'unit_provider_id' => 'required|exists:unit_providers,id',
        ]);

        DOSTEmployee::create([
            'name'             => $data['name'],
            'employee_id'      => $data['employee_id'],
            'unit_provider_id' => $data['unit_provider_id'],
            'status'           => 'Active',
        ]);

        return redirect()
            ->route('admin.employees')                // matches routes/web.php → name('employees')
            ->with('success', 'New employee created successfully.');
    }

    /** Update an existing Employee */
    public function update(Request $request, DOSTEmployee $employee)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'employee_id'      => 'required|string|max:255|unique:dost_employees,employee_id,'.$employee->id,
            'unit_provider_id' => 'required|exists:unit_providers,id',
        ]);

        $employee->update($data);

        return redirect()
            ->route('admin.employees')                // same here
            ->with('success', 'Employee updated successfully.');
    }

    /** Toggle Active/Inactive status (AJAX) */
    public function toggleStatus(DOSTEmployee $employee)
    {
        $employee->status = $employee->status === 'Active' ? 'Inactive' : 'Active';
        $employee->save();

        return response()->json([
            'success' => true,
            'status'  => $employee->status,
        ]);
    }
}
