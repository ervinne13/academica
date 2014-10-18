<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(StudentSeeder::class);
        $this->call(TeachersSeeder::class);
        $this->call(GradedItemTypesSeeder::class);
        $this->call(GradingPeriodsSeeder::class);
        $this->call(GradedItemSeeder::class);
    }

}
