<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConfigsTableSeeder extends Seeder
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
        		'name' => 'color.important',
        		'value' => '#FF0000',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'color.ongoing',
        		'value' => '#FFFF00',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'color.failed',
        		'value' => '#808080',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'color.completed',
        		'value' => '#00FF00',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'color.pending',
        		'value' => '#0000FF',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'working.start',
        		'value' => '08:30',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'name' => 'working.end',
        		'value' => '17:30',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
            [
                'name' => 'overtime.start',
                'value' => '18:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('configs')->insert($data);
    }
}
