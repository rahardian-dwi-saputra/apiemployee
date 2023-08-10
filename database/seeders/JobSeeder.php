<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('jobs')->insert([ 
        	[
                'job' => 'Network Administrator',
                'department_id' => 1
            ],[
                'job' => 'Cloud Infrastructure Architect',
                'department_id' => 1
            ],[
                'job' => 'Systems Analyst',
                'department_id' => 1
            ],[
                'job' => 'Full Stack Developer',
                'department_id' => 2
            ],[
                'job' => 'Software Engineer',
                'department_id' => 2
            ],[
                'job' => 'Quality Assurance Testers',
                'department_id' => 2
            ],[
                'job' => 'Manager',
                'department_id' => 3
            ],[
                'job' => 'Sales Representative',
                'department_id' => 3
            ],[
                'job' => 'Sr Manager',
                'department_id' => 4
            ],[
                'job' => 'Accountant',
                'department_id' => 4
            ],[
                'job' => 'IT Support',
                'department_id' => 5
            ],[
                'job' => 'IT Helpdesk',
                'department_id' => 5
            ],[
                'job' => 'Business Partner',
                'department_id' => 6
            ],[
                'job' => 'Human Resources Recruitment',
                'department_id' => 6
            ],
        ]);
    }
}
