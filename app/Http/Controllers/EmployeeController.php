<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Job;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        $count = Employee::count();
        if($count == 0){
            return response()->json([
                'success' => false,
                'message' => 'Data kosong' 
            ], 404);   
        }else{
            return response()->json([
                'success' => true,
                'data' => Employee::all() 
            ], 200);
        }
    }
    public function get_jobs(){
        $jobs = Job::select('id','job');
        if($jobs->count() == 0){
            return response()->json([
                'success' => false,
                'message' => 'Data kosong' 
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $jobs->get() 
        ], 200);
    }
    public function store(Request $request){
        $this->validate($request, [
            'full_name' => 'required',
            'job' => 'required',
            'hire_date' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'email' => 'nullable',
            'phone' => 'required',
            'address' => 'nullable',
            'salary' => 'nullable'
        ]);

        $n_data = Employee::count();
        if($n_data == 0){
            $request->merge(['employee_id' => 'E001']);
        }else{
            $last_id = Employee::max('employee_id');
            $next_id = ((int)str_replace('E', '', $last_id))+1;
            $request->merge(['employee_id' => 'E'.sprintf("%03s", $next_id)]);
        }
        //$request->merge(['job_id' => $request->job]);
        //$request->request->remove('job');
        //$employee = Employee::create($request->all());

        $employee = new Employee();
        $employee->employee_id = $request->employee_id;
        $employee->full_name = $request->input('full_name');
        $employee->job_id = $request->input('job');
        $employee->hire_date = $request->input('hire_date');
        $employee->gender = $request->input('gender');
        $employee->date_of_birth = $request->input('date_of_birth');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->address = $request->input('address');
        $employee->salary = $request->input('salary');
        $employee->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan data'
        ], 200);
    }
    public function show($id){
        $employee = Employee::find($id);

        if(!$employee){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan' 
            ], 404); 
        }
        return response()->json([
            'success' => true,
            'data' => $employee
        ], 200);    
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'full_name' => 'required',
            'job' => 'required',
            'hire_date' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'email' => 'nullable',
            'phone' => 'required',
            'address' => 'nullable',
            'salary' => 'nullable'
        ]);

        $employee = Employee::find($id);
        if(!$employee){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan' 
            ], 404); 
        }

        $employee->full_name = $request->input('full_name');
        $employee->job_id = $request->input('job');
        $employee->hire_date = $request->input('hire_date');
        $employee->gender = $request->input('gender');
        $employee->date_of_birth = $request->input('date_of_birth');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->address = $request->input('address');
        $employee->salary = $request->input('salary');
        $employee->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengedit data'
        ], 200);
    }
    public function destroy($id){
        $employee = Employee::find($id);

        if(!$employee){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan' 
            ], 404); 
        }
        $employee->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ], 200); 
    }
}
