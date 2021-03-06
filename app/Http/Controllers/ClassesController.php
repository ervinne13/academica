<?php

namespace App\Http\Controllers;

use App\Models\ClassGradedItem;
use App\Models\GradingYear;
use App\Models\Level;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class ClassesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view('pages.classes.index', $this->getDefaultViewData());
    }

    public function datatable() {
        return Datatables::of(
                        SchoolClass::
                                with('gradingYear')
                                ->with('subject')
                                ->with('level')
                                ->with('teacher')
                )->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData = $this->getFormViewData("ADD", 0);
        return view('pages.classes.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $class = new SchoolClass($request->toArray());
            $class->save();
            return $class;
        } catch (\Exception $e) {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($classId) {
        $viewData = $this->getFormViewData("EDIT", $classId);
        return view('pages.classes.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            $class = SchoolClass::find($id);
            $class->fill($request->toArray());
            $class->save();
            return $class;
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
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

    public function getGradedItems($classId) {
        return ClassGradedItem::with('gradedItem')->where('class_id', $classId)->get();
    }

    public function assignGradedItems(Request $request, $classId) {

        $class = SchoolClass::find($classId);

        if ($class) {
            try {
                $class->assignGradedItems($request->graded_items);
            } catch (\Exception $e) {
                return response($e->getMessage(), 500);
            }

            return "OK";
        } else {
            return response("Class not found", 404);
        }
    }

    public function assignGradedItem(Request $request, $classId) {

        $class = SchoolClass::find($classId);

        if ($class) {
            $class->assignGradedItem(
                    $request->graded_item_id, $request->highest_possible_score
            );

            return "OK";
        } else {
            return response("Class not found", 404);
        }
    }

    private function getFormViewData($mode, $classId) {


        // <editor-fold defaultstate="collapsed" desc="Validations">

        if ($classId == 0) {
            $class   = new SchoolClass();
            $teacher = new Teacher();
        } else {
            $class   = SchoolClass::find($classId);
            $teacher = $class->teacher;
        }

        if (!$class) {
            throw new NotFoundHttpException("School Class Not Found");
        }

        // </editor-fold>

        return array_merge($this->getDefaultViewData(), [
            "mode"         => $mode,
            "teacher"      => $teacher,
            "class"        => $class,
            //  options
            "teachers"     => Teacher::Alphabetical()->get(),
            "levels"       => Level::all(),
            "gradingYears" => GradingYear::Decending()->get(),
            "subjects"     => Subject::Active()->get()
        ]);
    }

}
