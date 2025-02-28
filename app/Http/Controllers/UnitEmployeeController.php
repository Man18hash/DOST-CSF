<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitProvider;
use App\Models\DOSTEmployee;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UnitEmployeeController extends Controller
{
    /**
     * Display the list of unit providers and employees.
     */
    public function index()
    {
        $unitProviders = UnitProvider::all();
        $employees = DOSTEmployee::with('unitProvider')->get(); // Eager load unitProvider
        return view('admin.unit_employee', compact('unitProviders', 'employees'));
    }

    /**
     * Fetch only units (for dedicated units page).
     */
    public function units()
    {
        $unitProviders = UnitProvider::all();
        return view('admin.units', compact('unitProviders'));
    }

    /**
     * Fetch only employees (for dedicated employees page).
     */
    public function employees()
    {
        $employees = DOSTEmployee::with('unitProvider')->get();
        $unitProviders = UnitProvider::all(); // 🔥 Add this line
        return view('admin.employees', compact('employees', 'unitProviders'));
    }

    /**
     * Toggle the status of a unit.
     */
    public function toggleUnitStatus($id)
    {
        try {
            $unit = UnitProvider::findOrFail($id);
            $unit->status = ($unit->status === 'Active') ? 'Inactive' : 'Active';
            $unit->save();

            return response()->json([
                'success' => true,
                'status' => $unit->status
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unit not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the unit status.'
            ], 500);
        }
    }

    /**
     * Toggle the status of an employee.
     */
    public function toggleEmployeeStatus($id)
    {
        try {
            $employee = DOSTEmployee::findOrFail($id);
            $employee->status = ($employee->status === 'Active') ? 'Inactive' : 'Active';
            $employee->save();

            return response()->json([
                'success' => true,
                'status' => $employee->status
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the employee status.'
            ], 500);
        }
    }
}
