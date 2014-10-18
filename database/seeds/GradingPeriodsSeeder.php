<?php

use App\Models\GradingPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradingPeriodsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("grading_periods")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $periods = [
            ["name" => "First Quarter", "short_name" => "Q1", "percentage_value" => 20],
            ["name" => "Second Quarter", "short_name" => "Q2", "percentage_value" => 20],
            ["name" => "Thrid Quarter", "short_name" => "Q3", "percentage_value" => 20],
            ["name" => "Finals", "short_name" => "Q4", "percentage_value" => 40],
        ];

        GradingPeriod::insert($periods);
    }

}
