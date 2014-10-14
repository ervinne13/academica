<?php

use App\Models\Subject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSubjectsEntries extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        //  subjects applies to grades 1 - 10 unless specified
        $subjects = [
            ["name" => "Mother Tounge", "short_name" => "Mother Tounge"], //  1 - 3
            ["name" => "Filipino", "short_name" => "Filpino"],
            ["name" => "English", "short_name" => "English"],
            ["name" => "Mathematics", "short_name" => "Math"],
            ["name" => "Science", "short_name" => "Science"],
            ["name" => "Araling Panlipunan", "short_name" => "AP"],
            ["name" => "Edukasyon sa Pagpapakatao (EsP)", "short_name" => "EsP"],
            ["name" => "Music", "short_name" => "Music"],
            ["name" => "Arts", "short_name" => "Arts"],
            ["name" => "Physical Education", "short_name" => "PE"],
            ["name" => "Health", "short_name" => "Health"],
            ["name" => "Edukasyong Pantahanan at Pangkabuhayan (EPP)", "short_name" => "EPP"], //  4 - 6
            ["name" => "Technology and Livelihood Education (TLE)", "short_name" => "TLE"]
        ];

        for ($i = 0; $i < count($subjects); $i ++) {
            $subjects[$i]["is_default"] = 1;
        }

        Subject::insert($subjects);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("subjects")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
