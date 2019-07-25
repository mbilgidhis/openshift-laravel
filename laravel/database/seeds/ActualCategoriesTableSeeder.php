<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActualCategoriesTableSeeder extends Seeder
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
    			'name' => 'Onsite',
    			'description' => '',
    			'parent_id' => null,
    			'created_by' => 1,
    			'updated_by' => 1,
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now()
    		],
    		[
    			'name' => 'Standby on Call',
    			'description' => '',
    			'parent_id' => null,
    			'created_by' => 1,
    			'updated_by' => 1,
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now()
    		],
    		[
    			'name' => 'Standby Onsite',
    			'description' => '',
    			'parent_id' => null,
    			'created_by' => 1,
    			'updated_by' => 1,
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now()
    		],
    		[
    			'name' => 'Remote at Office',
    			'description' => '',
    			'parent_id' => null,
    			'created_by' => 1,
    			'updated_by' => 1,
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now()
    		],
    		[
    			'name' => 'Remote Mobile',
    			'description' => '',
    			'parent_id' => null,
    			'created_by' => 1,
    			'updated_by' => 1,
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now()
    		],
    		[
    			'name' => 'Meeting',
    			'description' => '',
    			'parent_id' => null,
    			'created_by' => 1,
    			'updated_by' => 1,
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now()
    		],
    	];
        DB::table('actual_categories')->insert($data);
    }
}
