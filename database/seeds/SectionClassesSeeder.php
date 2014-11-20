<?php

use App\Models\Level;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionClassesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("section_classes")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sections = Section::all();
        $levels   = Level::all();

        $entries = [];

        foreach ($levels AS $level) {
            $subjects = $level->subjects;
            foreach ($subjects AS $subject) {
                $classes = SchoolClass::Level($level->id)->subject($subject->id);
                array_push($entries, [
                ]);
            }
        }

//        DB::table('level_subjects')->insert($entries);
    }

}
