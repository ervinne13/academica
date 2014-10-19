<?php

use App\Models\GradingYear;
use App\Models\Level;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("classes")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gradingYear = GradingYear::open()->first();
        $subjects    = Subject::all();
        $levels      = Level::all();
        $teachers    = Teacher::limit(count($subjects) * count($levels))->get();

        $classes = [];

        $teacherIndex = 0;

        foreach ($levels AS $level) {
            foreach ($subjects AS $subject) {
                $teacher                 = $teachers[$teacherIndex];
                $teacherFirstNameInitial = substr($teacher->first_name, 0, 1);

                array_push($classes, [
                    "grading_year_id" => $gradingYear->id,
                    "level_id"        => $level->id,
                    "subject_id"      => $subject->id,
                    "teacher_id"      => $teacher->user_id,
                    "name"            => "{$level->name} {$subject->short_name} ({$gradingYear->year}) - {$teacherFirstNameInitial}. {$teacher->last_name}"
                ]);

                $teacherIndex ++;
                //  reset
                if ($teacherIndex == 25) {
                    $teacherIndex = 0;
                }
            }
        }

        SchoolClass::insert($classes);
    }

}
