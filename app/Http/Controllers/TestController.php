<?php

namespace App\Http\Controllers;

use Academica\Grading\Transmuter;
use Academica\ReportCardFormatter;
use Academica\SectionStudentRankProvider;
use Academica\StudentGradesProvider;
use App\Models\ClassGradedItem;
use App\Models\GradingPeriod;
use App\Models\GradingYear;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Transmutation;
use SebastianBergmann\Comparator\Factory;
use function response;

class TestController extends Controller {

    public function test() {

        $transmutation = Transmutation::all();
        $transmuter    = new Transmuter($transmutation);

        $studentRecord = new StudentGradesProvider(Student::find(101));
        $studentRecord->setTransmuter($transmuter);

        $grades    = $studentRecord->getRecordsByPeriod();
//
//        return $grades;
        $formatter = new ReportCardFormatter();
        return $formatter->format($grades, 101, $transmuter);
//        $query = ClassGradedItem::EnrolledByStudent(64)->groupByFix();
//
//        $gradedItems      = $query->get();
//        $takenGradedItems = $query->gradedItemTaken()->get();
//
//        $gradedItemCount       = count($gradedItems);
//        $takenGradedItemsCount = count($takenGradedItems);
//
//        return "{$takenGradedItemsCount} / {$gradedItemCount}";
//        $monthlyGrades = StudentGrade::Monthly()->StudentId(101)->get();
//        return $monthlyGrades;

        $studentRanking = (new SectionStudentRankProvider())->getStudentsRanked(1);
        return $studentRanking;
    }

    public function pdf() {

        $studentId = 101;
        
        $currentGradingYear = GradingYear::open()->first();

        $query = ClassGradedItem::EnrolledByStudent($studentId)->groupByFix();

        $gradedItems      = $query->get();
        $takenGradedItems = $query->gradedItemTaken()->get();

        $viewData = array_merge($this->getDefaultViewData(), [
            "mode"                  => "VIEW",            
            "subjects"              => Subject::getSubjectsWithMapeh(),
            "student"               => Student::find($studentId),
            "gradingYear"           => $currentGradingYear,
            "gradingPeriod"         => GradingPeriod::find($currentGradingYear->currently_active_period_id),
            "gradedItemsCount"      => count($gradedItems),
            "takenGradedItemsCount" => count($takenGradedItems),
            "ordinalSuffix"         => array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th')
        ]);

        if (!$viewData["student"]) {
            return response("Student not found", 404);
        }

        $transmutation = Transmutation::all();
        $transmuter    = new Transmuter($transmutation);

        $studentRecord = new StudentGradesProvider($viewData["student"]);
        $studentRecord->setTransmuter($transmuter);

        $viewData["grades"] = $studentRecord->getRecordsByPeriod();

        $formatter        = new ReportCardFormatter();
        $viewData["card"] = $formatter->format($viewData["grades"], $viewData["student"]->id, $transmuter);

//        return view('printout.pdf.report-card', $viewData);
        
        $pdf = \PDF::loadView('printout.pdf.report-card', $viewData)->setPaper('a4')->setOrientation('landscape');
        return $pdf->download('report-card.pdf');
    }

}
