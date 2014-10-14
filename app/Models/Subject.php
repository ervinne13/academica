<?php

namespace App\Models;

class Subject extends BaseModel {

    public static function getSubjectsWithMapeh() {
        $mapeh       = ["Music", "Arts", "Physical Education", "Health"];
        $subjectsRaw = Subject::Active()->get();
        $subjects    = [
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
