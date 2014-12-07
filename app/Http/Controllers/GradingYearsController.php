<?php

namespace App\Http\Controllers;

use App\Models\GradingPeriod;
use App\Models\GradingYear;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class GradingYearsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view('pages.grading-years.index', $viewData);
    }

    public function datatable() {
        return Datatables::of(GradingYear::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $viewData                   = $this->getDefaultViewData();
        $viewData["gradingYear"]    = new GradingYear();
        $viewData["gradingPeriods"] = GradingPeriod::all();
        $viewData["mode"]           = "ADD";

        return view('pages.grading-years.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            $gradingYear = new GradingYear($request->toArray());
            $gradingYear->save();

            return $gradingYear;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $viewData                   = $this->getDefaultViewData();
        $viewData["gradingYear"]    = GradingYear::find($id);
        $viewData["gradingPeriods"] = GradingPeriod::all();
        $viewData["mode"]           = "EDIT";

        return view('pages.grading-years.form', $viewData);
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
            $gradingYear = GradingYear::find($id);
            $gradingYear->fill($request->toArray());
            $gradingYear->save();

            return $gradingYear;
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
