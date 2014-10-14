<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    public function scopeActive($query) {
        return $query->where($this->getIsActiveField(), '1');
    }

    private function getIsActiveField() {
        if (property_exists($this, 'isActiveField')) {
            return $this->isActiveField;
        } else {
            return "is_active";
        }
    }

}
