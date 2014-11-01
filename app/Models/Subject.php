<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Subject extends BaseModel {

    protected $fillable = [
        "is_active", "short_name", "name"
    ];

    public function scopeEnrolledByStudent($query, $userId) {
        return $query
                        ->select('subjects.*')
                        ->leftJoin('classes', 'subjects.id', '=', 'subject_id')
                        ->leftJoin('student_classes', 'classes.id', '=', 'class_id')
                        ->where('student_id', $userId);
    }

    public function scopeEnrolledByStudentOpenYear($query, $userId) {
        return $query
                        ->select(['subjects.*', 'teachers.user_id AS teacher_id', DB::raw('CONCAT(teachers.first_name, \' \', teachers.last_name) AS teacher_name')])
                        ->leftJoin('classes', 'subjects.id', '=', 'subject_id')
                        ->leftJoin('teachers', 'teachers.user_id', '=', 'teacher_id')
                        ->leftJoin('student_classes', 'classes.id', '=', 'class_id')
                        ->leftJoin('grading_years', 'classes.grading_year_id', '=', 'grading_years.id')
                        ->where('student_id', $userId)
                        ->where('is_open', 1);
    }

    public static function getSubjectsWithMapeh($query = null) {
        $mapeh = ["Music", "Arts", "Physical Education", "Health"];

        if ($query) {
            $subjectsRaw = $query->get();
        } else {
            $subjectsRaw = Subject::Active()->get();
        }

        $subjects = [
            "general" => [],
            "mapeh"   => []
        ];

        foreach ($subjectsRaw AS $subject) {
            if (in_array($subject["name"], $mapeh)) {
                array_push($subjects["mapeh"], $subject);
            } else {
                array_push($subjects["general"], $subject);
            }
        }

        return $subjects;
    }

}
