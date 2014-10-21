<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function view;

class HomeController extends Controller {

    public function index() {

        if (Auth::check()) {

            $roleName = Auth::user()->role_name;

            if ($roleName == "VIEWER") {
                return view('pages.home.viewer-welcome');
            } else {
                return view('pages.home.index');
            }
        } else {
            return view('welcome');
        }
    }

}
