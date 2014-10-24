<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradedItemType extends Model {

    public function gradedItems() {
        return $this->hasMany(GradedItem::class, 'type_id');
    }

}
