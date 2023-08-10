<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([ 
        	[
                'id' => 1,
                'department' => 'IT'
            ],[
                'id' => 2,
                'department' => 'Engineering'
            ],[
                'id' => 3,
                'department' => 'Sales'
            ],[
                'id' => 4,
                'department' => 'Finance'
            ],[
                'id' => 5,
                'department' => 'Support'
            ],[
                'id' => 6,
                'department' => 'Human Resource'
            ]
        ]);
    }
}
