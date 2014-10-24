<?php

namespace App\Http\Controllers;

use App\Models\GradedItemType;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected function getDefaultViewData() {
        $viewData = [];

        if (Auth::check() && Auth::user()->role_name == User::ROLE_TEACHER) {
            $viewData["gradedItemTypes"] = GradedItemType::all();
        }

        return $viewData;
    }

}
