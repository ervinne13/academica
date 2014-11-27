<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class TeachersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view('pages.teachers.index', $this->getDefaultViewData());
    }

    public function datatable() {
        return Datatables::of(Teacher::with('user'))->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $viewData = $this->getDefaultViewData();

        $viewData["mode"]          = "ADD";
        $viewData["teacher"]       = new Teacher();
        $viewData["teacher"]->user = new User();

        return view('pages.teachers.form', $viewData);
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

            $user            = new User();
            $user->seeded    = 0;
            $user->username  = $request->username;
            $user->name      = "{$request->first_name} {$request->last_name}";
            $user->role_name = User::ROLE_TEACHER;
            $user->password  = \Hash::make($request->password);
            $user->save();

            $teacher          = new Teacher($request->toArray());
            $teacher->user_id = $user->id;
            $teacher->save();

            DB::commit();
        } catch (Exception $e) {
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
        $viewData            = $this->getDefaultViewData();
        $viewData["teacher"] = Teacher::find($id);
        $viewData["mode"]    = "VIEW";

        return view('pages.teachers.form', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData            = $this->getDefaultViewData();
        $viewData["teacher"] = Teacher::find($id);
        $viewData["mode"]    = "EDIT";

        return view('pages.teachers.form', $viewData);
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
            DB::beginTransaction();

            $teacher = Teacher::find($id);
            $teacher->fill($request->toArray());
            $teacher->update();

            $user           = User::find($id);
            $user->username = $request->username;

            if ($request->password) {
                $user->password = \Hash::make($request->password);
            }

            $user->save();

            DB::commit();
        } catch (Exception $e) {
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

}
