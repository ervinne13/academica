<?php

namespace App\Models;

class ClassGradedItem extends BaseModel {

    public function gradedItem() {
        return $this->belongsTo(GradedItem::class);
    }

    public function scopeClassId($query, $classId) {
        return $query->where('class_id', $classId);
    }

    public function scopeGroupByFix($query) {
        return $query
                        ->select('class_graded_items.*')
                        ->groupBy([
                            'class_graded_items.graded_item_id',
                            'class_graded_items.class_id',
                            'class_graded_items.highest_possible_score',
                            'class_graded_items.is_active',
                            'class_graded_items.datetaken',
        ]);
    }

    public function scopeEnrolledByStudent($query, $studentId) {

        /*
          SELECT * FROM class_graded_items AS cgi
          RIGHT JOIN classes AS c ON  c.id = cgi.class_id
          RIGHT JOIN student_classes AS sc ON sc.class_id = c.id
          -- RIGHT JOIN student_grades AS sg ON sg.graded_item_id = cgi.graded_item_id AND sg.student_id = sc.student_id
          LEFT JOIN grading_years AS gy ON gy.id = c.grading_year_id
          WHERE gy.is_open = 1
          AND cgi.is_active = 1
          AND sc.student_id = 101
          GROUP BY cgi.graded_item_id
         */

        return $query
                        ->rightJoin('classes AS c', 'c.id', '=', 'class_graded_items.class_id')
                        ->rightJoin('student_classes AS sc', 'sc.class_id', '=', 'c.id')
                        ->rightJoin('grading_years AS gy', 'gy.id', '=', 'c.grading_year_id')
                        ->where('gy.is_open', 1)
                        ->where('class_graded_items.is_active', 1)
                        ->where('sc.student_id', $studentId)
                        ->groupBy('class_graded_items.graded_item_id')
        ;
    }

    public function scopeGradedItemTaken($query) {
        return $query->rightJoin('student_grades AS sg', function($join) {
                    $join->on('sg.graded_item_id', '=', 'class_graded_items.graded_item_id');
                    $join->on('sg.student_id', '=', 'sc.student_id');
                });
    }

}
