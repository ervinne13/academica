<?php

namespace App\Http\Controllers;

use function view;

class EnrollmentWizardController extends Controller {

    public function wizard() {
        return view('pages.enrollment.wizard', $this->getDefaultViewData());
    }

}
