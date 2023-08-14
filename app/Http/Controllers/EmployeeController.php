<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Job;
use Carbon\Carbon;

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
                'message' => 'Data Employee kosong' 
            ], 404);   
        }else{
            $employees = Employee::paginate(5);
            return response()->json([
                'success' => true,
                'data' => $employees->items(),
                'pagination' => [
                    'total' => $employees->total(),
                    'per_page' => $employees->perPage(),
                    'current_page' => $employees->currentPage(),
                    'last_page' => $employees->lastPage(),
                    'from' => $employees->firstItem(),
                    'to' => $employees->lastItem()
                ]
            ], 200);
        }
    }
    public function get_jobs(){
        $jobs = Job::select('id','job');
        if($jobs->count() == 0){
            return response()->json([
                'success' => false,
                'message' => 'Data Job kosong' 
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $jobs->get() 
        ], 200);
    }
    public function store(Request $request){
        $this->validate($request, [
            'full_name' => 'required|string',
            'job' => 'required|exists:jobs,id',
            'hire_date' => 'required|date_format:d-m-Y',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date_format:d-m-Y',
            'email' => 'nullable|email:dns|unique:employees,email',
            'phone' => 'required|max:20',
            'address' => 'nullable',
            'salary' => 'nullable|numeric'
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
        $employee->hire_date = Carbon::createFromFormat('d-m-Y', $request->input('hire_date'))->format('Y-m-d');
        $employee->gender = $request->input('gender');
        $employee->date_of_birth = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');
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
        $rules = [
            'full_name' => 'required|string',
            'job' => 'required|exists:jobs,id',
            'hire_date' => 'required|date_format:d-m-Y',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date_format:d-m-Y',
            'phone' => 'required|max:20',
            'address' => 'nullable',
            'salary' => 'nullable|numeric'
        ];

        $employee = Employee::find($id);
        if(!$employee){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan' 
            ], 404); 
        }

        if($employee->email != $request->input('email')){
            $rules['email'] = 'nullable|email:dns|unique:employees,email';
        }

        $this->validate($request, $rules);

        $employee->full_name = $request->input('full_name');
        $employee->job_id = $request->input('job');
        $employee->hire_date = Carbon::createFromFormat('d-m-Y', $request->input('hire_date'))->format('Y-m-d');
        $employee->gender = $request->input('gender');
        $employee->date_of_birth = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');
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
