<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewerAccessibleLinks extends Model {

    public $timestamps = false;

    public function scopeOwnedByUser($query, $userId) {
        return $query->where('user_id', $userId);
    }

}
