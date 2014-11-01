<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingYear extends Model {

    protected $table    = "grading_years";
    protected $fillable = [
        "year", "name", "currently_active_period_id"
    ];

    public function scopeDecending($query) {
        return $query->orderBy('year', 'DESC');
    }

    public function scopeOpen($query) {
        return $query->where('is_open', 1);
    }

}
