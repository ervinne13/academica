<?php

namespace App\Http\Controllers;

use Academica\Grading\Transmuter;
use Academica\ReportCardFormatter;
use Academica\StudentGradesProvider;
use App\Models\Student;
use App\Models\Transmutation;

class TestController extends Controller {

    public function test() {

        $transmutation = Transmutation::all();
        $transmuter    = new Transmuter($transmutation);

        $studentRecord = new StudentGradesProvider(Student::find(101));
        $studentRecord->setTransmuter($transmuter);

        $grades = $studentRecord->getRecordsByPeriod();

        $formatter = new ReportCardFormatter();
        return $formatter->format($grades, 101, $transmuter);
    }

}
