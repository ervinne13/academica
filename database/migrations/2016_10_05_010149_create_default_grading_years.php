<?php

use App\Models\GradingYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDefaultGradingYears extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $pastYear    = new GradingYear();
        $currentYear = new GradingYear();

        $pastYear->is_open = 0;
        $pastYear->name    = "Grading Year 2015";
        $pastYear->year    = 2015;

        $currentYear->is_open = 1;
        $currentYear->name    = "Grading Year 2016";
        $currentYear->year    = 2016;

        $pastYear->save();
        $currentYear->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("grading_years")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
