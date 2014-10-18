<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradedItem extends Model {

    public function scopeType($query, $type) {
        return $query
                        ->leftJoin('graded_item_types AS type', 'type.id', '=', 'type_id')
                        ->where('type.name', '=', $type)
        ;
    }

}
