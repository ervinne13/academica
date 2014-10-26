<?php

namespace Academica;

use Academica\Grading\Transmuter;
use App\Models\GradedItem;
use App\Models\GradedItemType;
use App\Models\StudentClass;
use App\Models\StudentGrade;

/**
 * Description of ClassRecord
 *
 * @author ervinne
 */
class ClassRecord {

    protected $period;
    protected $classId;

    /** @var Transmuter */
    protected $transmuter;

    public function __construct($period, $classId) {
        $this->period  = $period;
        $this->classId = $classId;
    }

    public function setTransmuter(Transmuter $transmuter) {
        $this->transmuter = $transmuter;
    }

    public function getCategorizedGradedItems() {
        $periodId = $this->period;
        $classId  = $this->classId;

        return GradedItemType::with(['gradedItems' => function($query) use ($periodId, $classId) {
                        return (new GradedItem())
                                        ->scopeClassWithHPS($query, $classId)
                                        ->where('grading_period_id', $periodId)
                        ;
                    }])->get();
    }

    public function getCategorizedActiveGradedItems() {
        $periodId = $this->period;
        $classId  = $this->classId;

        return GradedItemType::with(['gradedItems' => function($query) use ($periodId, $classId) {
                        return (new GradedItem())
                                        ->scopeClassWithActiveHPS($query, $classId)
                                        ->where('grading_period_id', $periodId)
                        ;
                    }])->get();
    }

    public function getStudentGrades() {
        $rawGrades    = StudentGrade::ClassId($this->classId)->get();
        $mappedGrades = [];

        //  raw grades conversion loop
        foreach ($rawGrades AS $grade) {
            if (!array_key_exists($grade->student_id, $mappedGrades)) {
                $mappedGrades[$grade->student_id]            = [];
                $mappedGrades[$grade->student_id]["summary"] = [];
            }

            $mappedGrades[$grade->student_id][$grade->graded_item_id] = $grade->score;
        }

        //  compute grades
        $categorizedGradedItems = $this->getCategorizedActiveGradedItems();
        $classStudents          = StudentClass::ClassStudents($this->classId)->get();

        foreach ($classStudents AS $student) {

            if (!array_key_exists($student->id, $mappedGrades)) {
                //  since this student is not mapped yet in the first in the
                //  raw grades conversion loop (see above), it means the student
                //  has not taken this graded item yet. Assume 0 grade
                $mappedGrades[$student->id]            = [];
                $mappedGrades[$student->id]["summary"] = [];
            }

            foreach ($categorizedGradedItems AS $gradedItemType) {

                $hpsTotal   = 0;
                $totalScore = 0;

                foreach ($gradedItemType->gradedItems AS $classGradedItem) {

                    if (!array_key_exists($classGradedItem->id, $mappedGrades[$student->student_id])) {
                        $mappedGrades[$student->id][$classGradedItem->id] = "";
                    } else {
                        $totalScore += $mappedGrades[$student->id][$classGradedItem->id];
                    }

                    $hpsTotal += $classGradedItem->highest_possible_score;
                }

                //  only do computation if there is HPS.
                //  no HPS happens if a category / graded item type does not have
                //  active graded items yet
                if ($hpsTotal > 0) {
                    //  percentage score
                    $ps = ($totalScore / $hpsTotal) * 100;
                    //  weighed score
                    $ws = $ps * ($gradedItemType->percentage_value / 100);

                    $mappedGrades[$student->id]["summary"][$gradedItemType->id] = [
                        "gradedItemType" => $gradedItemType,
                        "total"          => $totalScore,
                        "ps"             => $ps,
                        "ws"             => $ws
                    ];
                }
            }

            if (count($mappedGrades[$student->id]["summary"])) {

                $totalPercentageWeight = 0;

                foreach ($mappedGrades[$student->id]["summary"] AS $key => $gradeSummary) {
                    $totalPercentageWeight += $gradeSummary["gradedItemType"]->percentage_value;
                }

                $initialGrade = 0;

                foreach ($mappedGrades[$student->id]["summary"] AS $gradeSummary) {
                    $weight = ($gradeSummary["gradedItemType"]->percentage_value / $totalPercentageWeight) * 100;
                    $initialGrade += $gradeSummary["ps"] * $weight / 100;
                }

                $mappedGrades[$student->id]["summary"]["initialGrade"] = $initialGrade;

                if ($this->transmuter) {
                    $mappedGrades[$student->id]["summary"]["transmutedGrade"] = $this->transmuter->transmute($initialGrade);
                }
            }
        }

        return $mappedGrades;
    }

}
