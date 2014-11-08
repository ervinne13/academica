<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model {

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'level_subjects');
    }

}
