<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('employees')->insert([
            'first_name' => 'somin', 
            'last_name' => 'dadhaniya',
            'company_id' => 2,
            'email' => "somindadhaniya111@gmail.com",
             'phone' => "8469518057" 
            
        ]);
    }
}
