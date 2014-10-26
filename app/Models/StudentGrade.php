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

    public function scopeStudentId($query, $studentId) {
        return $query->where('student_grades.student_id', $studentId);
    }

    public function scopePeriodId($query, $periodId) {
        return $query
                        ->leftJoin('graded_items', 'graded_items.id', '=', 'graded_item_id')
                        ->where('grading_period_id', $periodId)
        ;
    }

    public function scopeGradingYear($query, $gradingYear) {
        return $query
                        ->leftJoin('student_classes AS sc', 'sc.student_id', '=', 'student_grades.student_id')
                        ->leftJoin('classes AS c', 'c.id', '=', 'sc.class_id')
                        ->leftJoin('grading_years AS gy', 'gy.id', '=', 'c.grading_year_id')
                        ->where('gy.year', $gradingYear)
        ;
    }

    // <editor-fold defaultstate="collapsed" desc="Relationship">

    public function gradedItem() {
        return $this->belongsTo(GradedItem::class);
    }

    // </editor-fold>
}
