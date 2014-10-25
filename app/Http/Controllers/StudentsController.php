<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {        
        
        $viewData = array_merge($this->getDefaultViewData(), [
            "mode"     => "VIEW",
            "faker"    => Factory::create(),
            "subjects" => Subject::getSubjectsWithMapeh(),
            "student"  => Student::find($id)
        ]);

        if (!$viewData["student"]) {
            return response("Student not found", 404);
        }

//        $viewData["rankedSubjectScores"] = [
//            ["subject" => "Mathematics", "percentage" => 92],
//            ["subject" => "Science", "percentage" => 89],
//            ["subject" => "English", "percentage" => 88],
//            ["subject" => "Filipino", "percentage" => 85],
//            ["subject" => "Araling Panlipunan", "percentage" => 85],
//            ["subject" => "Edukasyong Pagpapakatao", "percentage" => 84],
//            ["subject" => "Filipino", "percentage" => 85],
//            ["subject" => "Edukasyong Pantahanan at Pangkabuhayan (EPP)", "percentage" => 83],
//            ["subject" => "Technology and Livelihood Education (TLE)", "percentage" => 83],
//        ];

        $viewData["rankedSubjectScores"] = [
            ["subject" => "Technology and Livelihood Education (TLE)", "percentage" => 92],
            ["subject" => "Filipino", "percentage" => 91],
            ["subject" => "Edukasyong Pantahanan at Pangkabuhayan (EPP)", "percentage" => 90],
            ["subject" => "Araling Panlipunan", "percentage" => 85],
            ["subject" => "Edukasyong Pagpapakatao", "percentage" => 84],
            ["subject" => "Filipino", "percentage" => 84],
            ["subject" => "English", "percentage" => 80],
            ["subject" => "Mathematics", "percentage" => 75],
            ["subject" => "Science", "percentage" => 73],
        ];

        return view('pages.students.show', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
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

}
