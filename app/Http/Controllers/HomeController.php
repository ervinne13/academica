<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function view;

class HomeController extends Controller {

    public function index() {

        if (Auth::check()) {
            return view('pages.home.index');
        } else {
            return view('welcome');
        }
    }

}
