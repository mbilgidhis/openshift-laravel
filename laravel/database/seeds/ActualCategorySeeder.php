<?php

use Illuminate\Database\Seeder;

class ActualCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ActualCategory::class, 5)->create();
    }
}
