<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Employees;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employees::all();
        return view('company.employee', compact('employees'));
    }

    public function create()
    {    
        $companies=Company::all();
        return view('company.createEmployee',compact('companies')); 
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id'=>'required',
            'email' => 'nullable',
            'phone' => 'nullable',
            
        ]);

       $inventory= new Employees();
       $inventory->first_name=$request->first_name;
       $inventory->last_name=$request->last_name;
       $inventory->email=$request->email;
       $inventory->phone=$request->phone;
       $inventory->company_id=$request->company_id;
       $inventory->save();

        return redirect()->route('employees.index')->with('success', 'Inventory item created successfully.');
    }

    public function edit(Employees $employee)
    {
        $companies=Company::all();
        return view('company.editEmployee', compact('employee','companies'));
    }

    public function update(Request $request, Employees $employee)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable',
            'phone' => 'nullable',
        ]);

        $employee->update($validatedData);

        return redirect()->route('employees.index')->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(Employees $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Inventory item deleted successfully.');
    }

    
  

}