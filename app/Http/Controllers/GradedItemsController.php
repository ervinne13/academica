<?php

namespace App\Http\Controllers;

use App\Models\GradedItem;
use App\Models\GradedItemType;
use App\Models\GradingPeriod;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class GradedItemsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData                     = $this->getDefaultViewData();
        $viewData["gradedItemTypeId"] = 0;
        return view('pages.graded-items.index', $viewData);
    }

    public function typeIndex($gradedItemTypeId) {
        $viewData                     = $this->getDefaultViewData();
        $viewData["gradedItemTypeId"] = $gradedItemTypeId;
        return view('pages.graded-items.index', $viewData);
    }

    public function getBySubject($subjectId) {
        return GradedItem::BySubject($subjectId)->get();
    }

    public function datatable($gradedItemTypeId = null) {

        if ($gradedItemTypeId) {
            return Datatables::of(GradedItem::datatable()->type($gradedItemTypeId))->make(true);
        } else {
            return Datatables::of(GradedItem::datatable())->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
//        return $this->getViewData(0);
        return view('pages.graded-items.form', $this->getViewData(0));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $gradedItem = new GradedItem($request->toArray());
            $gradedItem->save();
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
        return view('pages.graded-items.form', $this->getViewData($id));
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
            $gradedItem = GradedItem::find($id);
            $gradedItem->fill($request->toArray());
            $gradedItem->save();
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

    function getViewData($gradedItemId) {
        $viewData = array_merge($this->getDefaultViewData(), [
            "gradingPeriods"  => GradingPeriod::all(),
            "gradedItemTypes" => GradedItemType::all(),
            "subjects"        => Subject::all()
        ]);

        if ($gradedItemId == 0) {
            $viewData["mode"]       = "ADD";
            $viewData["gradedItem"] = new GradedItem();
        } else {
            $viewData["mode"]       = "EDIT";
            $viewData["gradedItem"] = GradedItem::find($gradedItemId);
        }

        return $viewData;
    }

}
