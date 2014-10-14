<?php

use App\Models\GradingPeriod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDefaultGradingPeriods extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $quarters = [
            ["name" => "First Quarter", "short_name" => "Q1", "percentage_value" => 20],
            ["name" => "Second Quarter", "short_name" => "Q2", "percentage_value" => 20],
            ["name" => "Third Quarter", "short_name" => "Q3", "percentage_value" => 20],
            ["name" => "Fourth Quarter (Finals)", "short_name" => "Q4", "percentage_value" => 40],
        ];

        GradingPeriod::insert($quarters);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("grading_periods")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
