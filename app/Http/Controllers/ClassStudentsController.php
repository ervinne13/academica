<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use Exception;
use Illuminate\Http\Response;
use function response;

class ClassStudentsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($classId) {
        return Student::enrolledInClass($classId)->get();
    }

    public function destroy($classId, $studentId) {
        try {
            StudentClass::where("class_id", $classId)
                    ->where("student_id", $studentId)
                    ->delete()
            ;

            return "OK";
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

}
