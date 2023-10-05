<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()

    {
        $employees = Employee::all();
        return view('backend.employee.index',compact('employees'));
    }

        public function store(Request $request)
        {
            $validatedData = $request->validate([
                'employee_name' => 'required|string|max:255',
            ]);

            $employee = new Employee();
            $employee->employee_name = $validatedData['employee_name'];
            $employee->slug         = Str::slug($employee->employee_name);
            $employee->save();

            return response()->json(['message' => 'Employee created successfully', 'employee' => $employee], 201);
        }

        public function update(Request $request, Employee $employee)
        {
            try {
                $request->validate([
                    'employee_name' => 'required|string|max:255',
                ]);

                // Update Employee data
                $employee->employee_name = $request->input('employee_name');
                $employee->slug         = Str::slug($request->input('employee_name'));
                $employee->save();

                return response()->json(['message' => 'Employee updated successfully']);
            } catch (\Exception $e) {
                return response()->json(['error'   => 'An error occurred while updating the Employee.'], 500);
            }
        }

        public function destroy(Employee $employee)
        {
            $employee->delete();

            return response()->json(['message' => 'Employee deleted successfully']);
        }


}
