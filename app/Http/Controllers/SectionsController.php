<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\SectionClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class SectionsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        return view('pages.sections.index', $this->getDefaultViewData());
    }

    public function datatable() {
        return Datatables::of(Section::Datatable())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *      
     * @return Response
     */
    public function create() {

        $viewData = $this->getDefaultViewData();

        $viewData["section"] = new Section();
        $viewData["mode"]    = "ADD";
        $viewData["levels"]  = Level::all();
        $viewData["classes"] = SchoolClass::all();

        return view('pages.sections.form', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $section = new Section($request->toArray());
            $section->save();

            return $section;
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
        $viewData = $this->getDefaultViewData();

        $viewData["section"]           = Section::find($id);
        $viewData["mode"]              = "EDIT";
        $viewData["levels"]            = Level::all();
        $viewData["selectableClasses"] = SchoolClass::all();

        return view('pages.sections.form', $viewData);
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
            $section = Section::find($id);
            if (!$section) {
                return response("Section not found", 404);
            }

            $section->fill($request->toArray());
            $section->update();

            return $section;
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

    public function classes($id) {
        return SchoolClass::section($id)->get();
    }

    public function storeClass(Request $request) {

        try {
            $sectionClass = SectionClass::firstOrNew([
                        "section_id" => $request->section_id,
                        "class_id"   => $request->class_id
            ]);

            $sectionClass->save();
            return "OK";
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function destroyClass($sectionId, $classId) {

        try {
            SectionClass::where([
                "section_id" => $sectionId,
                "class_id"   => $classId
            ])->delete();
            return "OK";
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function destroyAllClass($sectionId) {

        try {
            SectionClass::where([
                "section_id" => $sectionId
            ])->delete();
            return "OK";
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

}
