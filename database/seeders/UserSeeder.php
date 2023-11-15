<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        	[
                'name' => 'Administrator',
        		'username' => 'admin',
        		'password' => Hash::make('admin123'),
        		'is_admin' => true
        	],[
                'name' => 'Guest',
        		'username' => 'guest',
        		'password' => Hash::make('guest'),
        		'is_admin' => false
        	],
        ]);
    }
}
