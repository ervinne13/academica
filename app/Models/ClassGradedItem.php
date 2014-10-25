<?php

namespace App\Models;

class ClassGradedItem extends BaseModel {

    public function gradedItem() {
        return $this->belongsTo(GradedItem::class);
    }

    public function scopeClassId($query, $classId) {
        return $query->where('class_id', $classId);
    }

}
