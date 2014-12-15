<?php

namespace Academica;

use Academica\Grading\Transmuter;
use App\Models\GradedItem;
use App\Models\GradedItemType;
use App\Models\GradingPeriod;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentGrade;

/**
 * Description of StudentRecord
 *
 * @author ervinne
 */
class StudentGradesProvider {

    /** @var Student */
    protected $student;

    /** @var Transmuter */
    protected $transmuter;

    public function __construct(Student $student) {
        $this->student = $student;
    }

    public function setTransmuter(Transmuter $transmuter) {
        $this->transmuter = $transmuter;
    }

    /**
     * @returns StudentRecords
     */
    public function getRecordsByPeriod() {

        $studentSections = $this->student->sections;

        $gradedItemTypes = GradedItemType::all();
        $periods         = GradingPeriod::all();
        $classes         = SchoolClass::OpenGradingYear()
                ->ByStudent($this->student->id)
//                ->section($studentSections[0]->section_id)
                ->SelectClassOnly()
                ->get();

        $recordsByPeriod = [];

        foreach ($periods AS $period) {
            $records              = [];
            $initialGradeTotal    = 0;
            $transmutedGradeTotal = 0;
            $totalSubjectCount    = 0;

            $gradedItemTypeSummary = [];

            foreach ($gradedItemTypes AS $gradedItemType) {
                $gradedItemTypeSummary[$gradedItemType->id] = [
                    "name"  => $gradedItemType->name,
                    "grade" => 0,
                    "count" => 0
                ];
            }

            foreach ($classes AS $class) {
                $subjectGrades = $this->getSubjectGradesFromClass($class, $period->id);

                $records[$class->subject_id] = $subjectGrades->toArray();

                $initialGradeTotal    += $subjectGrades->getInitialGrade();
                $transmutedGradeTotal += $subjectGrades->getTransmutedGrade();
                $totalSubjectCount ++;

                $summary = $subjectGrades->getGradedItemTypeSummaryMap();

                foreach ($gradedItemTypes AS $gradedItemType) {
                    if (array_key_exists($gradedItemType->id, $summary)) {
                        $gradedItemTypeSummary[$gradedItemType->id]["grade"] += $summary[$gradedItemType->id]["ps"];
                        $gradedItemTypeSummary[$gradedItemType->id]["count"] ++;
                    }
                }
            }

            foreach ($gradedItemTypes AS $gradedItemType) {
                if ($gradedItemTypeSummary[$gradedItemType->id]["count"] > 0) {
                    $initialGrade                                        = $gradedItemTypeSummary[$gradedItemType->id]["grade"] / $gradedItemTypeSummary[$gradedItemType->id]["count"];
                    $gradedItemTypeSummary[$gradedItemType->id]["grade"] = $this->transmuter->transmute($initialGrade);
                }
            }

            $recordsByPeriod[$period->id]                            = $records;
            $recordsByPeriod[$period->id]["initialGrade"]            = $totalSubjectCount > 0 ? $initialGradeTotal / $totalSubjectCount : 0;
            $recordsByPeriod[$period->id]["transmutedGrade"]         = $this->transmuter->transmute($recordsByPeriod[$period->id]["initialGrade"]);
//            $recordsByPeriod[$period->id]["transmutedGrade"]         = $totalSubjectCount > 0 ? $transmutedGradeTotal / $totalSubjectCount : 60;
            $recordsByPeriod[$period->id]["summaryByGradedItemType"] = $gradedItemTypeSummary;
//            $recordsByPeriod[$period->id] = $records;
        }

        return $recordsByPeriod;
    }

    /**
     * 
     * @param SchoolClass $class
     * @returns SubjectGrades
     */
    public function getSubjectGradesFromClass(SchoolClass $class, $periodId) {

        $gradedItems = GradedItem::ClassWithActiveHPS($class->id)
                ->period($periodId)
                ->get();

        $rawGrades = StudentGrade::
                ClassId($class->id)
                ->StudentId($this->student->id)
                ->PeriodId($periodId)
                ->get();

        $grades = new SubjectGrades();
        $grades->setSubject($class->subject);
        $grades->setClass($class);

        $grades->autoTransmute($this->transmuter);
        $grades->produce($gradedItems, $rawGrades);

        return $grades;
    }

}
