<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanCategoriesTableSeeder extends Seeder
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
        		'name' => 'Project', // 1
        		'description' => '',
        		// 'parent_id' => null,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Self Learning', // 2
        		'description' => '',
        		// 'parent_id' => null,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Opty', // 3
        		'description' => '',
        		'parent_id' => null,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Others', // 4
        		'description' => '',
        		'parent_id' => null,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Implementation', // 5
        		'description' => '',
        		'parent_id' => 1,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Support', // 6
        		'description' => '',
        		'parent_id' => 1,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Class Training', // 7
        		'description' => '',
        		'parent_id' => 2,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Exam', // 8
        		'description' => '',
        		'parent_id' => 2,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Other Training', // 9
        		'description' => '',
        		'parent_id' => 2,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Assesment', // 10
        		'description' => '',
        		'parent_id' => 3,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'PoC', // 11
        		'description' => '',
        		'parent_id' => 3,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Instalasi',
        		'description' => '',
        		'parent_id' => 5,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Konfigurasi',
        		'description' => '',
        		'parent_id' => 5,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Tuning',
        		'description' => '',
        		'parent_id' => 5,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Preventive Maintenance',
        		'description' => '',
        		'parent_id' => 6,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'Corrective Maintenance',
        		'description' => '',
        		'parent_id' => 6,
        		'created_by' => 1,
        		'updated_by' => 1,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        ];

        DB::table('plan_categories')->insert($data);
    }
}
