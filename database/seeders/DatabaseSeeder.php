<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	DepartmentSeeder::class,
            JobSeeder::class,
            UserSeeder::class
        ]);
        for($i=0; $i<30; $i++)
             Employee::factory()->create();
    }
}
