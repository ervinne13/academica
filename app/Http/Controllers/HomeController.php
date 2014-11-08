<?php

namespace App\Http\Controllers;

use App\Models\GradingPeriod;
use App\Models\GradingYear;
use App\Models\Level;
use Illuminate\Support\Facades\Auth;
use function session;
use function view;

class HomeController extends Controller {

    public function index() {

        if (Auth::check()) {

            $roleName = Auth::user()->role_name;

            if ($roleName == "VIEWER") {
                return view('pages.home.viewer-welcome', $this->getDefaultViewData());
            } else if ($roleName == "TEACHER") {

                $viewData = $this->getDefaultViewData();

                $viewData["teacher"]     = Auth::user()->teacher;
                $viewData["teachers"]    = [$viewData["teacher"]];
                $viewData["classes"]     = $viewData["teacher"]->classes;
                $viewData["levels"]      = Level::all();
                $viewData["periods"]     = GradingPeriod::all();
                $viewData["schoolYears"] = GradingYear::all();
                $viewData["mode"]        = "UPLOAD";

                return view('pages.home.teacher-welcome', $viewData);
            } else {
                return view('pages.home.index', $this->getDefaultViewData());
            }
        } else {
            return view('welcome', $this->getDefaultViewData());
        }
    }

    public function register() {
        return view('pages.home.register', $this->getDefaultViewData());
    }

    public function changeAdminView($type) {
        session('admin_view', $type);
//        return redirect('/');       
        return session('admin_view');
    }

}
