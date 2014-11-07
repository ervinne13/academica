<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function view;

class HomeController extends Controller {

    public function index() {

        if (Auth::check()) {

            $roleName = Auth::user()->role_name;

            if ($roleName == "VIEWER") {
                return view('pages.home.viewer-welcome', $this->getDefaultViewData());
            } else if ($roleName == "TEACHER") {
                return view('pages.home.teacher-welcome', $this->getDefaultViewData());
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
