<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionClass extends Model {

    protected $table      = "section_classes";
    protected $fillable   = [
        "section_id", "class_id"
    ];
    protected $increments = false;
    public $timestamps    = false;

    public function classes() {
        return $this->hasMany(SchoolClass::class, 'id', 'class_id');
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function scopeClassId($query, $classId) {
        return $query->where('class_id', $classId);
    }

    public function scopeInClassId($query, $classIdList) {
        return $query->whereIn('class_id', $classIdList);
    }

}
