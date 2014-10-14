<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model {

    public $timestamps  = false;
    protected $fillable = ["level_id", "name"];

    public function scopeDatatable($query) {
        return $query
                        ->select(["sections.id AS section_id", "levels.name AS level_name", "sections.name AS section_name"])
                        ->leftJoin('levels', 'level_id', '=', 'levels.id')
        ;
    }

    // <editor-fold defaultstate="collapsed" desc="Relationships">

    public function level() {
        return $this->belongsTo(Level::class);
    }

    // </editor-fold>
}
