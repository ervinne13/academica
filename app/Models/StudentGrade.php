<?php

namespace App\Models;

class StudentGrade extends CompositeKeyModel {

    protected $primaryKey = [
        "class_id", "graded_item_id", "subject_id", "student_id"
    ];
    protected $fillable   = [
        "class_id", "graded_item_id", "subject_id", "student_id",
        "highest_possible_score", "score", "grade"
    ];

    public function scopeClassId($query, $classId) {
        return $query->where('class_id', $classId);
    }

}
