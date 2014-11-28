<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ViewerAccessibleLinks;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view('pages.users.index', $this->getDefaultViewData());
    }

    public function datatable() {
        return Datatables::of(User::query())->make(true);
    }

    public function activate($userId) {

        $user = User::find($userId);

        if ($user) {
            try {
                $user->is_active = 1;
                $user->save();
            } catch (Exception $e) {
                return response($e->getMessage(), 500);
            }
        } else {
            return response("User not found", 404);
        }
    }

    public function deactivate($userId) {

        $user = User::find($userId);

        if ($user) {
            try {
                $user->is_active = 0;
                $user->save();
            } catch (Exception $e) {
                return response($e->getMessage(), 500);
            }
        } else {
            return response("User not found", 404);
        }
    }

    public function changePassword($userId) {
        $viewData         = $this->getDefaultViewData();
        $viewData["user"] = User::find($userId);
        return view('pages.users.change-password', $viewData);
    }

    public function updatePassword(Request $request, $userId) {

        try {
            $user           = User::find($userId);
            $user->password = \Hash::make($request->new_password);
            $user->save();
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $viewData         = $this->getDefaultViewData();
        $viewData["user"] = new User();
        $viewData["mode"] = "ADD";

        //  only viewers may be created from here
        $viewData["user"]->role_name = User::ROLE_VIEWER;

        return view('pages.users.form', $viewData);
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

            $user            = new User($request->toArray());
            $user->role_name = User::ROLE_VIEWER;
            $user->password  = \Hash::make($request->password);
            $user->save();

            $formattedLinks = explode(',', $request->links);
            foreach ($formattedLinks AS $formattedLink) {
                $splittedLink = explode(':', $formattedLink);
                if (count($splittedLink) == 2) {    //  splitted link is only valid if it contains 2 parts
                    $access         = new ViewerAccessibleLinks();
                    $access->name   = $splittedLink[0];
                    $access->url    = $splittedLink[1];
                    $access->status = "Approved";

                    $access->user_id = $user->id;
                    $access->save();
                } else {
                    throw new Exception("The link(s) format is invalid");
                }
            }

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $viewData         = $this->getDefaultViewData();
        $viewData["user"] = User::find($id);
        $viewData["mode"] = "EDIT";

        if ($viewData["user"]->role_name == User::ROLE_VIEWER) {
            return view('pages.users.viewer-form', $viewData);
        } else {
            return view('pages.users.form', $viewData);
        }
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

            $user = User::find($id);

            if (!$user) {
                return response("User not found", 404);
            }

            $user->fill($request->toArray());

            $user->role_name = User::ROLE_VIEWER;

            if ($request->password) {
                $user->password = \Hash::make($request->password);
            }

            $user->save();

            //  clear user links
            ViewerAccessibleLinks::OwnedByUser($user->id)->delete();

            $formattedLinks = explode(',', $request->links);
            foreach ($formattedLinks AS $formattedLink) {
                $splittedLink = explode(':', $formattedLink);
                if (count($splittedLink) == 2) {    //  splitted link is only valid if it contains 2 parts
                    $access         = new ViewerAccessibleLinks();
                    $access->name   = $splittedLink[0];
                    $access->url    = $splittedLink[1];
                    $access->status = "Approved";

                    $access->user_id = $user->id;
                    $access->save();
                } else {
                    throw new Exception("The link(s) format is invalid");
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
//            throw $e;
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
