<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class SubjectsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view('pages.subjects.index');
    }

    public function datatable() {
        return Datatables::of(Subject::with('levelSubjects'))->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData            = $this->getDefaultViewData();
        $viewData["subject"] = new Subject();
        $viewData["mode"]    = "ADD";

        return view('pages.subjects.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            $subject = new Subject($request->toArray());
            $subject->save();
            return $subject;
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData            = $this->getDefaultViewData();
        $viewData["subject"] = Subject::find($id);
        $viewData["mode"]    = "EDIT";

        return view('pages.subjects.form', $viewData);
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
            $subject = Subject::find($id);
            $subject->fill($request->toArray());
            $subject->update();
            return $subject;
        } catch (Exception $e) {
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
