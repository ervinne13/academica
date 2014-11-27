<?php

namespace App\Http\Controllers;

use App\Models\GradedItem;
use App\Models\SchoolClass;
use App\Models\StudentClass;
use App\Models\StudentGrade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function response;
use function view;

class ClassGradingController extends Controller {

    public function create($classId, $gradedItemId) {
        $class = SchoolClass::find($classId);

        $viewData                 = $this->getDefaultViewData();
        $viewData["class"]        = $class;
        $viewData["gradedItemId"] = $gradedItemId;

        return view('pages.class-grading.create', $viewData);
    }

    public function students($classId, $gradedItemId) {

        $students      = StudentClass::ClassStudents($classId)->get();
        $studentGrades = StudentGrade::ClassId($classId)->gradedItemid($gradedItemId)->with('student')->get();

        $studentsWithScores = [];

        foreach ($students AS $student) {

            $record = [
                "student_id"   => $student->id,
                "student_name" => "{$student->first_name} {$student->last_name}",
                "score"        => "",
            ];

            foreach ($studentGrades AS $grade) {
                if ($grade->student_id == $student->id) {
                    $record["score"] = $grade->score;
                    break;
                }
            }

            array_push($studentsWithScores, $record);
        }

        return $studentsWithScores;
    }

    public function store(Request $request) {

        $class      = SchoolClass::find($request->class_id);
        $gradedItem = GradedItem::WithHPS($request->graded_item_id, $class->id)->first();

        $records = json_decode($request->records, true);

        try {

            DB::beginTransaction();

            foreach ($records AS $record) {

                $grade = StudentGrade::firstOrNew([
                            "class_id"       => $class->id,
                            "graded_item_id" => $gradedItem->id,
                            "subject_id"     => $class->subject->id,
                            "student_id"     => $record["student_id"],
                ]);

                $grade->score                  = $record["score"];
                $grade->highest_possible_score = $gradedItem->highest_possible_score;
                $grade->grade                  = $grade->score / $grade->highest_possible_score * 100;                
                $grade->save();
            }

            DB::commit();

            return $records;
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

}
