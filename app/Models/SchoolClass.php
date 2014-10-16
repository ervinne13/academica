<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolClass extends Model {

    protected $table    = "classes";
    protected $fillable = [
        "grading_year_id", "level_id", "subject_id", "teacher_id", "name"
    ];

    public function enroll($studentId) {
        return DB::table("student_classes")->insert([
                    "class_id"   => $this->id,
                    "student_id" => $studentId
        ]);
    }

    // <editor-fold defaultstate="collapsed" desc="Relationships">

    public function gradingYear() {
        return $this->belongsTo(GradingYear::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    // </editor-fold>
}
