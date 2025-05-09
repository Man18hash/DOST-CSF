<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitProvider;
use App\Models\Office;
use App\Models\DOSTEmployee;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UnitEmployeeController extends Controller
{
    /**
     * Display the Units page.
     */
    public function units()
    {
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
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'unit_name' => 'required|string|max:255',
            'office_id' => 'required|exists:offices,id',
        ]);

        try {
            $unit = UnitProvider::findOrFail($id);
            $unit->unit_name = $data['unit_name'];
            $unit->office_id = $data['office_id'];
            $unit->save();

            return redirect()
                ->route('admin.units')
                ->with('success', 'Unit updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.units')
                ->with('error', 'Unit not found.');
        }
    }

    /**
     * Toggle Active/Inactive status for a unit (AJAX).
     */
    public function toggleUnitStatus($id)
    {
        try {
            $unit = UnitProvider::findOrFail($id);
            $unit->status = $unit->status === 'Active' ? 'Inactive' : 'Active';
            $unit->save();

            return response()->json([
                'success' => true,
                'status'  => $unit->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error toggling unit status.',
            ], 500);
        }
    }

    /**
     * Display the Employees page.
     */
    public function employees()
    {
        $employees     = DOSTEmployee::with('unitProvider.office')->get();
        $offices       = Office::all();
        $unitProviders = UnitProvider::with('office')->get();

        return view('admin.employees', compact('employees', 'offices', 'unitProviders'));
    }

    /**
     * Store a newly created employee.
     */
    public function storeEmployee(Request $request)
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
            ->route('admin.employees')
            ->with('success', 'New employee created successfully.');
    }

    /**
     * Update an existing employee.
     */
    public function updateEmployee(Request $request, $id)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'employee_id'      => 'required|string|max:255|unique:dost_employees,employee_id,' . $id,
            'unit_provider_id' => 'required|exists:unit_providers,id',
        ]);

        try {
            $employee = DOSTEmployee::findOrFail($id);
            $employee->update($data);

            return redirect()
                ->route('admin.employees')
                ->with('success', 'Employee updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.employees')
                ->with('error', 'Employee not found.');
        }
    }

    /**
     * Toggle Active/Inactive status for an employee (AJAX).
     */
    public function toggleEmployeeStatus($id)
    {
        try {
            $emp = DOSTEmployee::findOrFail($id);
            $emp->status = $emp->status === 'Active' ? 'Inactive' : 'Active';
            $emp->save();

            return response()->json([
                'success' => true,
                'status'  => $emp->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error toggling employee status.',
            ], 500);
        }
    }
}
