<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassGradedItem extends Model {

    public function gradedItem() {
        return $this->belongsTo(GradedItem::class);
    }

}
