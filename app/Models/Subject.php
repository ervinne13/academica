<?php

namespace App\Models;

class Subject extends BaseModel {

    public function scopeEnrolledByStudent($query, $userId) {
        return $query
                        ->select('subjects.*')
                        ->leftJoin('classes', 'subjects.id', '=', 'subject_id')
                        ->leftJoin('student_classes', 'classes.id', '=', 'class_id')
                        ->where('student_id', $userId);
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
