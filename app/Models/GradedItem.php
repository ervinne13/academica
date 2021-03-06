<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradedItem extends Model {

    protected $fillable = [
        "name", "short_name", "type_id", "subject_id", "grading_period_id"
    ];

    public function scopeActiveOfStudentInOpenYear($query, $studentId) {
        return $query
                        ->leftJoin('class_graded_items', 'graded_items.id', '=', 'graded_item_id')
                        ->leftJoin('classes', 'classes.id', '=', 'class_id')
                        ->leftJoin('grading_years', 'grading_years.id', '=', 'grading_year_id')
                        ->leftJoin('student_classes', 'student_classes.class_id', '=', 'classes.id')
                        ->leftJoin('student_grades', 'student_grades.graded_item_id', '=', 'class_graded_items.graded_item_id')
                        ->where('is_open', 1)
                        ->where('is_active', 1)
                        ->where('student_classes.student_id', $studentId)

        ;
    }

    public function scopeType($query, $type) {
        return $query->where('type_id', '=', $type);
    }

    public function scopeBySubject($query, $subjectId) {
        return $query->where('subject_id', $subjectId);
    }

    public function scopeDatatable($query) {

        $columns = [
            'graded_items.id',
            'graded_items.name',
            'graded_items.short_name',
            'subjects.name AS subject_name', // for searching
            'subjects.short_name AS subject_short_name',
            'graded_item_types.name AS type_name',
            'grading_periods.name AS grading_period'
        ];

        return $query
                        ->select($columns)
                        ->leftJoin('graded_item_types', 'graded_item_types.id', '=', 'type_id')
                        ->leftJoin('subjects', 'subjects.id', '=', 'subject_id')
                        ->leftJoin('grading_periods', 'grading_periods.id', '=', 'grading_period_id')
        ;
    }

    public function scopeClassWithHPS($query, $classId) {

        return $query
                        ->rightJoin('class_graded_items', 'graded_item_id', '=', 'id')
                        ->where('class_id', $classId)
        ;
    }

    public function scopeClassWithActiveHPS($query, $classId) {

        return $query
                        ->rightJoin('class_graded_items', 'graded_item_id', '=', 'id')
                        ->where('class_id', $classId)
                        ->where('is_active', 1)
        ;
    }

    public function scopeWithHPS($query, $gradedItemId, $classId) {

        return $query
                        ->rightJoin('class_graded_items', 'graded_item_id', '=', 'id')
                        ->where('class_id', $classId)
                        ->where('graded_item_id', $gradedItemId)
        ;
    }

    public function scopeWithActiveHPS($query, $gradedItemId, $classId) {

        return $query
                        ->rightJoin('class_graded_items', 'graded_item_id', '=', 'id')
                        ->where('class_id', $classId)
                        ->where('graded_item_id', $gradedItemId)
                        ->where('is_active', 1)
        ;
    }

    public function scopePeriod($query, $periodId) {
        return $query->where('grading_period_id', $periodId);
    }

    // <editor-fold defaultstate="collapsed" desc="Relationships">

    public function gradedItemType() {
        return $this->belongsTo(GradedItemType::class, 'type_id');
    }

    /**
     * gradedItemType Alias
     * @return type
     */
    public function type() {
        return $this->gradedItemType();
    }

    public function gradingPeriod() {
        return $this->belongsTo(GradingPeriod::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    // </editor-fold>
}
