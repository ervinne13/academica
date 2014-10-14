<?php

use App\Models\Level;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLevelsEntries extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        $levels = [
            ["name" => "Grade 1"],
            ["name" => "Grade 2"],
            ["name" => "Grade 3"],
            ["name" => "Grade 4"],
            ["name" => "Grade 5"],
            ["name" => "Grade 6"],
            ["name" => "Grade 7"],
            ["name" => "Grade 8"],
            ["name" => "Grade 9"],
            ["name" => "Grade 10"],
//            ["name" => "Grade 11"],
//            ["name" => "Grade 12"]
        ];

        Level::insert($levels);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("levels")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
