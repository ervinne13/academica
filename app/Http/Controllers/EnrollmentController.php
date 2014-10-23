<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use function view;

class EnrollmentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $currentUser = Auth::user();

        if ($currentUser->isAdmin()) {
            $viewData = array_merge($this->getDefaultViewData(), [
                "teachers" => Teacher::all(),
                "classes"  => SchoolClass::all()
            ]);
        } else {
            $teacher  = Teacher::find($currentUser->id);
            $viewData = array_merge($this->getDefaultViewData(), [
                "teachers" => [$teacher],
                "classes"  => $teacher->classes
            ]);
        }

        return view('pages.enrollment.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $class = SchoolClass::find($request->class_id);

        if ($class) {
            try {
                $class->enroll($request->student_id);
                return "OK";
            } catch (\Exception $e) {
                return response($e->getMessage(), 500);
            }
        } else {
            return response("Class not found", 404);
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
