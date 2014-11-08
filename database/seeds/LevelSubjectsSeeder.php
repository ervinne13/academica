<?php

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSubjectsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("level_subjects")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $levels   = Level::all();
        $subjects = Subject::all();

        $entries = [];

        foreach ($levels AS $level) {
            foreach ($subjects AS $subject) {

                $include = //  mother tounge is for grades 1 - 3
                        !(($subject->short_name == "Mother Tounge" && $level->id > 3) ||
                        //  EPP is for grades 4 - 6
                        ($subject->short_name == "EPP" && ($level->id < 4 || $level->id > 6)));


                if ($include) {
                    array_push($entries, [
                        "level_id"   => $level->id,
                        "subject_id" => $subject->id
                    ]);
                }
            }
        }

        DB::table('level_subjects')->insert($entries);
    }

}
