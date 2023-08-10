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
        $n_data = Employee::count();
        if($n_data == 0){
            $id = 'E001';
        }else{
            $last_id = Employee::max('employee_id');
            $next_id = ((int)str_replace('E', '', $last_id))+1;
            $id = 'E'.sprintf("%03s", $next_id);
        }

        $employees = Employee::all();
        return response()->json($id);
    }
    public function get_jobs(){
        $jobs = Job::select('id','job')->get();
        return response()->json($jobs);
    }
}
