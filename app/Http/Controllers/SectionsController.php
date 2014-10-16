<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Section;
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

        return view('pages.sections.index');
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

        $section = new Section();
        $mode    = "ADD";
        $levels  = Level::all();

        return view('pages.sections.form', compact(['section', 'mode', 'levels']));
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
        $section = Section::find($id);
        $mode    = "EDIT";
        $levels  = Level::all();

        return view('pages.sections.form', compact(['section', 'mode', 'levels']));
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

}