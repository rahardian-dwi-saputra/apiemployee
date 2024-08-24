<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Job;
use Carbon\Carbon;
use App\Http\Resources\JobResource;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Gate;

/**
 * @group Employee Management
 *
 * API to manage the employee resource.
 */
class EmployeeController extends Controller
{
    
    /**
     * Get All Employees
     *
     * This endpoint is used to fetch all employees available in the database.
     * @authenticated
     * @queryParam page_size int Size per page. Defaults to 5. Example: 10
     * @queryParam page int Page to view. No-example
     */
    public function index(Request $request){
        if(Employee::count() == 0){
            return response()->json([
                'success' => false,
                'message' => 'Data Employee kosong' 
            ], 404);   
        }else{
            $employees = Employee::with('job')->paginate($request->page_size ?? 5);
            return response()->json([
                'success' => true,
                'data' => EmployeeResource::collection($employees->items()),
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

    /**
     * Get All Jobs
     *
     * This endpoint is used to fetch all jobs available in the database.
     * @authenticated
     */
    public function get_jobs(){ 
        if(Job::count() == 0){
            return response()->json([
                'success' => false,
                'message' => 'Data Job kosong' 
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => JobResource::collection(Job::with('department')->get()) 
        ], 200);
    }

    /**
     * Create a employee
     *
     * This endpoint lets you create a new employee.
     * @authenticated
     * @bodyParam full_name string required The full name of the employee. No-example
     * @bodyParam job string The id of the job. Example: 1
     * @bodyParam phone string The phone number of the employee. Example: 0821xxxxxxxx
     * @bodyParam salary number The salary of the employee. Example: 8000000
     */
    public function store(Request $request){
        $this->validate($request, [
            'full_name' => 'required|string|max:255',
            'job' => 'required|exists:jobs,id',
            'hire_date' => 'required|date_format:d-m-Y',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date_format:d-m-Y',
            'email' => 'nullable|email:dns|unique:employees,email|max:255',
            'phone' => 'required|max:20',
            'address' => 'nullable',
            'salary' => 'nullable|numeric|max:20'
        ]);

        if(Employee::count() == 0){
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
            'message' => 'Berhasil menyimpan data',
            'data' => new EmployeeResource($employee)
        ], 200);
    }

    /**
     * Get a Single Employee
     *
     * This endpoint is used to return a single employees from the database.
     * @authenticated
     * @urlParam id string required The ID of the employee. Example: E001
     */
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
            'data' => new EmployeeResource($employee)
        ], 200);    
    }

    /**
     * Update a employee
     *
     * This endpoint lets you update a employee.
     * @authenticated
     * @urlParam id required The id of the employee. Example: E001
     * @bodyParam full_name string required The full name of the employee. No-example
     * @bodyParam job string The id of the job. Example: 1
     * @bodyParam phone string The phone number of the employee. Example: 0821xxxxxxxx
     * @bodyParam salary number The salary of the employee. Example: 8000000
     */
    public function update(Request $request, $id){
        $rules = [
            'full_name' => 'required|string|max:255',
            'job' => 'required|exists:jobs,id',
            'hire_date' => 'required|date_format:d-m-Y',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date_format:d-m-Y',
            'phone' => 'required|max:20',
            'address' => 'nullable',
            'salary' => 'nullable|numeric|max:20'
        ];

        $employee = Employee::find($id);
        if(!$employee){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan' 
            ], 404); 
        }

        if($employee->email != $request->input('email')){
            $rules['email'] = 'nullable|email:dns|unique:employees,email|max:255';
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
            'message' => 'Berhasil mengedit data',
            'data' => new EmployeeResource($employee)
        ], 200);
    }

    /**
     * Delete a employee
     *
     * This endpoint lets you delete a employee.
     * @authenticated
     * @urlParam id required The id of the employee. Example: E001
     * 
     * @response {
     *  "success": true,
     *  "message": "Data berhasil dihapus",
     * }
     */
    public function destroy($id){

        if (Gate::denies('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'You must be an administrator'
            ], 403); 
        }

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
