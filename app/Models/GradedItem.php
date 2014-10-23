<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradedItem extends Model {

    protected $fillable = [
        "name", "short_name", "type_id", "subject_id", "grading_period_id"
    ];

    public function scopeType($query, $type) {
        return $query->where('type_id', '=', $type)
        ;
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
