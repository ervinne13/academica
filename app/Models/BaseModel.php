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

    public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey) {
        $model        = new $related;
        $table        = $model->getTable();
        $throughModel = new $through;
        $pivot        = $throughModel->getTable();

        //Student::class, StudentClass::class, 'class_id', 'id', 'student_id'
        //join student_classes ON student_id = students.id
        return $model
                        ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
                        ->select($table . '.*')
                        ->where($pivot . '.' . $firstKey, '=', $this->id);
    }

}
