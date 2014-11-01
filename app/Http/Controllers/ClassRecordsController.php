<?php

namespace App\Http\Controllers;

use Academica\ClassRecord;
use Academica\ClassRecordExcelImport;
use Academica\Grading\Transmuter;
use App\Models\GradingPeriod;
use App\Models\SchoolClass;
use App\Models\StudentClass;
use App\Models\Teacher;
use App\Models\Transmutation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use function redirect;
use function view;

class ClassRecordsController extends Controller {

    protected $destinationPath;

    public function __construct() {
        $this->destinationPath = "uploads";
    }

    public function index($teacherId = null) {
        $viewData              = $this->getDefaultViewData();
        $viewData["mode"]      = "VIEW";
        $viewData["teacherId"] = $teacherId;
        return view('pages.class-records.index', $viewData);
    }

    public function generate($periodId, $classId) {

        $viewData         = $this->getClassRecordViewData($periodId, $classId);
        $viewData["mode"] = "GENERATE";

        $spreadSheet = Excel::create($viewData["class"]->name, function($excel) use ($viewData) {

                    $excel->sheet('Class Record', function($sheet) use ($viewData) {
                        $sheet->loadView('excel.class-record', $viewData);

                        //  color cells accordingly
                        $columnCount = 3;
                        $colorIndex  = 0;
                        $colors      = ["#DAEEF3", "#D8E4BC", "#E6B8B7"];
                        for ($row = 2; $row <= 4; $row ++) {
                            $previousGradedItemCount = 4;
                            foreach ($viewData["categorizedGradedItems"] AS $category) {
                                $startLetter = chr(64 + $previousGradedItemCount);
                                $endLetter   = chr(64 + $previousGradedItemCount + count($category->gradedItems) + 2);

                                $columnRange = "{$startLetter}{$row}:{$endLetter}{$row}";

                                $sheet->cells($columnRange, function($cells) use ($colors, $colorIndex) {
                                    $cells->setBackground($colors[$colorIndex]);
                                });

                                $colorIndex ++;
                                if ($colorIndex > 2) {
                                    $colorIndex = 0;
                                }

                                //  +1 for next letter
                                $previousGradedItemCount += count($category->gradedItems) + 2 + 1;
                            }

                            //  +3 for Total, PS, and WS
                            $columnCount+= count($viewData["categorizedGradedItems"]) + 3;
                        }

                        $startLetter = chr(64 + 4);
                        $endLetter   = chr(64 + $columnCount + 2); // +2 for initial grade and transmuted grade
                        //  center columns D onwards (up to the last column)
                        $sheet->cells("{$startLetter}:{$endLetter}", function($cells) {
                            $cells->setAlignment('center');
                        });
                    });
                });

        //  hide first row
        $spreadSheet->getActiveSheet()->getRowDimension(1)->setVisible(false);
        $spreadSheet->getActiveSheet()->getColumnDimension('A')->setVisible(false);

        $spreadSheet->download('xlsx');
    }

    public function classRecord($periodId, $classId) {
        $viewData         = $this->getClassRecordViewData($periodId, $classId);
        $viewData["mode"] = "VIEW";

//        return $viewData["students"];
        return view('pages.class-records.show', $viewData);
    }

    protected function getClassRecordViewData($periodId, $classId) {

        $transmutation = Transmutation::all();
        $transmuter    = new Transmuter($transmutation);

        $classRecord = new ClassRecord($periodId, $classId);
        $classRecord->setTransmuter($transmuter);

        $viewData             = $this->getDefaultViewData();
        $viewData["periods"]  = GradingPeriod::all();
        $viewData["period"]   = GradingPeriod::find($periodId);
        $viewData["class"]    = SchoolClass::find($classId);
        $viewData["students"] = StudentClass::ClassStudents($classId)->get();
        $viewData["grades"]   = $classRecord->getStudentGrades();

        $viewData["categorizedGradedItems"] = $classRecord->getCategorizedGradedItems();

        return $viewData;
    }

    public function create() {
        $viewData = $this->getFormViewData();
        return view('pages.class-records.form', $viewData);
    }

    public function edit($classId) {
        
    }

    protected function getFormViewData() {
        $viewData = $this->getDefaultViewData();

        if (Auth::user()->role_name == User::ROLE_TEACHER) {
            $teacher              = Auth::user()->teacher;
            $viewData["teachers"] = [$teacher];
            $viewData["classes"]  = $teacher->classes;
        } else {
            $viewData["teachers"] = Teacher::all();
            $viewData["classes"]  = SchoolClass::all();
        }

        $viewData["periods"] = GradingPeriod::all();
        $viewData["mode"]    = "UPLOAD";

        return $viewData;
    }

    public function store(Request $request, ClassRecordExcelImport $import) {
        $import->importToDB($request->class_id);
        return redirect("/period/{$request->period_id}/class/{$request->class_id}/class-record");
    }

}
