<?php

namespace App\Http\Controllers;

use Academica\Grading\Transmuter;
use Academica\ReportCardFormatter;
use Academica\SectionStudentRankProvider;
use Academica\StudentGradesProvider;
use App\Models\ClassGradedItem;
use App\Models\GradingPeriod;
use App\Models\GradingYear;
use App\Models\SchoolClass;
use App\Models\SectionClass;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\Subject;
use App\Models\Transmutation;
use Exception;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class StudentsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view('pages.students.index', $this->getDefaultViewData());
    }

    public function datatable() {
        //  TODO: filter this later
        return Datatables::of(Student::Datatable())->make(true);
    }

    public function search(Request $request) {
        $keyword = $request->q;
        $classId = $request->classId;
        $page    = $request->page;

        $totalCount = Student::GetKeywordMatchSize($keyword, $classId);
        $students   = Student::Keyword($keyword, $classId, ($page - 1) * 30, 30)->get();

//        echo Student::Keyword($keyword, $classId, ($page - 1) * 30, 30)-> toSql();

        return [
            "total_count"        => $totalCount,
            "incomplete_results" => $totalCount > count($students),
            "items"              => $students
        ];
    }

    public function getGrades($studentId) {

        $transmutation = Transmutation::all();
        $transmuter    = new Transmuter($transmutation);

        $studentRecord = new StudentGradesProvider(Student::find($studentId));
        $studentRecord->setTransmuter($transmuter);

        return $studentRecord->getRecordsByPeriod();

//        return StudentGrade::GradingYear(date('Y'))->studentId($studentId)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData            = $this->getDefaultViewData();
        $viewData["mode"]    = "ADD";
        $viewData["student"] = new Student();

        return view('pages.students.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            $student = new Student($request->toArray());
        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }

        try {
            $student->save();

            return $student;
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {

        $currentGradingYear = GradingYear::open()->first();

        $query = ClassGradedItem::EnrolledByStudent($id)->groupByFix();

        $gradedItems      = $query->get();
        $takenGradedItems = $query->gradedItemTaken()->get();

        $monthlyGrades = StudentGrade::Monthly()->StudentId($id)->get();

        $viewData = array_merge($this->getDefaultViewData(), [
            "mode"                  => "VIEW",
            "faker"                 => Factory::create(),
            "subjects"              => Subject::getSubjectsWithMapeh(),
            "student"               => Student::find($id),
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

        for ($i = 0; $i < count($monthlyGrades); $i ++) {
            $monthGrade                            = $monthlyGrades[$i]["total_grade"] / $monthlyGrades[$i]["grade_count"];
            $monthlyGrades[$i]["transmuted_grade"] = $transmuter->transmute($monthGrade);
        }

        $viewData["monthlyGrades"] = $monthlyGrades;

        $viewData["studentsRanked"] = [];
        $classes                    = SchoolClass::ByStudent($id)->get();

        if ($classes) {
            $classIdList = [];
            foreach ($classes AS $class) {
                array_push($classIdList, $class->id);
            }
            $section = SectionClass::InClassId($classIdList)->first();

            if ($section) {
                $rankProvider               = new SectionStudentRankProvider();
                $viewData["studentsRanked"] = $rankProvider->getStudentsRanked($section->section_id);
            }
        }

        return view('pages.students.show', $viewData);
//        return $viewData["studentsRanked"];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData            = $this->getDefaultViewData();
        $viewData["mode"]    = "EDIT";
        $viewData["student"] = Student::find($id);

        if ($viewData["student"]) {
            return view('pages.students.form', $viewData);
        } else {
            return response("Student Not Found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $student = Student::find($id);

        if ($student) {
            try {
                $student->fill($request->toArray());
            } catch (Exception $e) {
                return response($e->getMessage(), 400);
            }

            try {
                $student->save();
                return $student;
            } catch (Exception $e) {
                return response($e->getMessage(), 500);
            }
        } else {
            return response("Student not found", 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    public function printCard($studentId) {
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
