<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Department;

class UsersTableSeeder extends Seeder
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
        		'name' => 'Super Admin',
                'email' => 'super@andibasko.ro',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('super1234'),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'department_id' => Department::all()->random()->id
        	],
            [
                'name' => 'Admin',
                'email' => 'admin@andibasko.ro',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('admin1234'),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'department_id' => Department::all()->random()->id
            ],
            [
                'name' => 'Staff',
                'email' => 'staff@andibasko.ro',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('staff1234'),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'department_id' => Department::all()->random()->id
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@andibasko.ro',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('manager1234'),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'department_id' => Department::all()->random()->id
            ],
            [
                'name' => 'Andi Baskoro',
                'email' => 'baskoro.ruliawan@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('andi1234'),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'department_id' => Department::all()->random()->id
            ],
            [
                'name' => 'Winda Febriana',
                'email' => 'windahongfebriana@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('metrocom123'),
                'created_by' => 1,
                'updated_by' => 1,
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'department_id' => Department::all()->random()->id
            ],
        ];

        DB::table('users')->insert($data);

        $info = [
            [
                'phone' => '08112654324',
                'address' => null,
                'user_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'phone' => '08112654324',
                'address' => null,
                'user_id' => 2,
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'phone' => '08112654324',
                'address' => null,
                'user_id' => 3,
                'created_by' => 3,
                'updated_by' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'phone' => '08112654324',
                'address' => null,
                'user_id' => 4,
                'created_by' => 4,
                'updated_by' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'phone' => '08112654324',
                'address' => null,
                'user_id' => 5,
                'created_by' => 5,
                'updated_by' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'phone' => '087884182202',
                'address' => null,
                'user_id' => 6,
                'created_by' => 6,
                'updated_by' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('user_information')->insert($info);
    }
}
