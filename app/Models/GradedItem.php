<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradedItem extends Model {

    protected $fillable = [
        "name", "short_name", "type_id", "subject_id", "grading_period_id"
    ];

    public function scopeType($query, $type) {
        return $query
                        ->leftJoin('graded_item_types AS type', 'type.id', '=', 'type_id')
                        ->where('type.name', '=', $type)
        ;
    }

    public function type() {
        return $this->belongsTo(GradedItemType::class);
    }

}
