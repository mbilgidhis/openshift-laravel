<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	// $this->call(DepartmentSeeder::class);
        $this->call(DepartmentsTableSeeder::class); 
        $this->call(UsersTableSeeder::class);
        $this->call(UserRolePermissionTableSeeder::class);
        // $this->call(PlanCategorySeeder::class);
        // $this->call(PlanCategoriesTableSeeder::class);
        // $this->call(ActualCategorySeeder::class);
        $this->call(ActualCategoriesTableSeeder::class);
        // $this->call(PlanSeeder::class);
        // $this->call(ActualSeeder::class);
        $this->call(ConfigsTableSeeder::class);
    }
}
