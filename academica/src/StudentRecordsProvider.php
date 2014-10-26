<?php

namespace Academica;

use Academica\Grading\Transmuter;
use App\Models\GradedItem;
use App\Models\GradingPeriod;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentGrade;

/**
 * Description of StudentRecord
 *
 * @author ervinne
 */
class StudentRecordsProvider {

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
        $periods = GradingPeriod::all();
        $classes = SchoolClass::ByStudent($this->student->id)->get();

        $recordsByPeriod = [];

        foreach ($periods AS $period) {
            $records = new StudentRecords();
            foreach ($classes AS $class) {
                $records->addSubjectGrades($this->getSubjectGradesFromClass($class, $period->id));
            }
            $recordsByPeriod[$period->id] = $records->toArray();
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
