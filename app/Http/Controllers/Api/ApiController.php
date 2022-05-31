<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class ApiController extends Controller
{
    // Create API - POST
    public function createEmployee(Request $request){
        // Validation
        $request->validate([
            "name"      =>  "required", 
            "email"     =>  "required|email|unique:employees", 
            "phone_no"  =>  "required", 
            "gender"    =>  "required", 
            "age"       =>  "required"
        ]);

        
        // create data
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_no = $request->phone_no;
        $employee->gender = $request->gender;
        $employee->age = $request->age;

        // Save
        $employee->save();
        // send response
        return response()->json([
            "status"    =>  201,
            "message"   =>  "Employee created successfully"
        ], 201);
    }

    // List API - GET
    public  function listEmployees(){
        $employees = Employee::get();
        return response()->json([
            "status"    =>  200,
            "message"   =>  "Listing Employees",
            "data"      =>  $employees
        ], 200);
    }

    // Single Detail API - GET
    public function getSingleEmployee($id){
        if(Employee::where("id", $id)->exists()){
            $employee_detail = Employee::where("id", $id)->first();
            return response()->json([
                "status"    =>  200,
                "message"   => "Single Employee",
                "data"      => $employee_detail
            ], 200);
        }else{
            return response()->json([
                "status"    =>  404,
                "message"   =>  "Single Employee Not Found",
            ], 404);
        }
    }

    // Update API - PUT
    public function updateEmployee(Request $request, $id){
        if(Employee::where("id", $id)->exists()){
            $employee = Employee::find($id);

           // $employee = new Employee();
            $employee->name = !empty($request->name)? $request->name : $employee->name;
            $employee->email = !empty($request->email)? $request->email : $employee->email;
            $employee->phone_no = !empty($request->phone_no)? $request->phone_no : $employee->phone_no;
            $employee->gender = !empty($request->gender)? $request->gender : $employee->gender;
            $employee->age = !empty($request->age)? $request->age : $employee->age;

           $employee->save();

            return response()->json([
                "status"    =>  200,
                "message"   =>  "Employee Updated Successfully",
                "data"      =>  $employee
            ], 200);

        }else{
            return response()->json([
                "status"    =>  404,
                "message"   =>  "Single Employee Not Found",
            ], 404);
        }
    }

    // Delete API - DELETE
    public function deleteEmployee($id){
        if(Employee::where("id", $id)->exists()){
            $employee = Employee::find($id);
            $employee->delete();

            return response()->json([
                "status"    =>  200,
                "message"   =>  "Employee Deleted Successfully"
            ]);
        }else{
            return response()->json([
                "status"    =>  404,
                "message"   =>  "Employee Not Found",
            ], 404);
        }
    }
}
