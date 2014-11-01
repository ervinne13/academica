<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class StudentGrade extends CompositeKeyModel {

    protected $primaryKey = [
        "class_id", "graded_item_id", "subject_id", "student_id"
    ];
    protected $fillable   = [
        "class_id", "graded_item_id", "subject_id", "student_id",
        "highest_possible_score", "score", "grade"
    ];

    public function scopeGradedItemid($query, $gradedItemId) {
        return $query->where('graded_item_id', $gradedItemId);
    }

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

    public function scopeOpenGradingYear($query) {
        return $query
                        ->rightJoin('class_graded_items AS cgi', 'cgi.graded_item_id', '=', 'student_grades.graded_item_id')
                        ->leftJoin('student_classes AS sc', 'sc.student_id', '=', 'student_grades.student_id')
                        ->leftJoin('classes AS c', 'c.id', '=', 'sc.class_id')
                        ->leftJoin('grading_years AS gy', 'gy.id', '=', 'c.grading_year_id')
                        ->where('gy.is_open', 1)
                        ->where('cgi.is_active', 1)
        ;
    }

    public function scopeMonthly($query) {
        $query->select([
                    DB::raw('MONTHNAME(datetaken) AS month_taken'), DB::raw('SUM(student_grades.grade) AS total_grade'), DB::raw('COUNT(student_grades.grade) AS grade_count')
                ])
                ->leftJoin('class_graded_items', 'class_graded_items.graded_item_id', '=', 'student_grades.graded_item_id')
                ->whereNotNull('datetaken')
                ->groupBy('datetaken')
        ;
    }

    // <editor-fold defaultstate="collapsed" desc="Relationship">

    public function gradedItem() {
        return $this->belongsTo(GradedItem::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    // </editor-fold>
}
