<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        	[
        		'name' => 'Software',
        		'description' => '',
                'created_by' => 1,
                'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now(),
        	]
        ];

        DB::table('departments')->insert($data);
    }
}