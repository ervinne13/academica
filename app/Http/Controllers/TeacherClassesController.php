<?php

namespace App\Http\Controllers;

use App\Models\GradingYear;
use App\Models\Level;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Yajra\Datatables\Datatables;
use function abort;
use function response;
use function view;

class TeacherClassesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($teacherId) {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            $viewData             = $this->getDefaultViewData();
            $viewData ["teacher"] = $teacher;

            return view('pages.teachers.classes.index', $viewData);
        } else {
            abort(404);
        }
    }

    public function listJSON($teacherId) {
        $teacher = Teacher::find($teacherId);
        return $teacher
                        ->classes()
                        ->with('gradingYear')
                        ->with('subject')
                        ->with('level')
                        ->get();
    }

    public function datatable($teacherId) {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            return Datatables::of(
                            $teacher
                                    ->classes()
                                    ->with('gradingYear')
                                    ->with('subject')
                                    ->with('level')
                    )->make(true);
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($teacherId) {
        $viewData = $this->getFormViewData("ADD", $teacherId, 0);
        return view('pages.teachers.classes.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {

            DB::beginTransaction();

            $requestAssoc = $request->toArray();
            unset($requestAssoc["class_id"]);

            $class = new SchoolClass($requestAssoc);
            $class->save();

            $class->assignGradedItemsNonTrans($request->gradedItems);

            DB::commit();

            return $class;
        } catch (\Exception $e) {
            DB::rollBack();
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
    public function edit($teacherId, $classId) {
        $viewData = $this->getFormViewData("EDIT", $teacherId, $classId);
        return view('pages.teachers.classes.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $teacherId, $classId) {

        try {

            DB::beginTransaction();

            $class = SchoolClass::find($classId);
            $class->fill($request->toArray());
            $class->update();

            $class->assignGradedItemsNonTrans($request->gradedItems);

            DB::commit();

            return $class;
        } catch (\Exception $e) {
            DB::rollBack();
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

    private function getFormViewData($mode, $teacherId, $classId) {
        $teacher = Teacher::find($teacherId);

        // <editor-fold defaultstate="collapsed" desc="Validations">

        if (!$teacher) {
            throw new NotFoundHttpException("Teacher Not Found");
        }

        if ($classId == 0) {
            $class = new SchoolClass();
        } else {
            $class = SchoolClass::find($classId);
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
