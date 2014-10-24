<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model {

    protected $table = "student_classes";

    public function scopeClassStudents($query, $classId) {
        return $query
                        ->leftJoin('students', 'students.id', '=', 'student_id')
                        ->where('class_id', $classId)
                        ->orderBy('last_name');
    }

    public function students() {
        return $this->hasMany(Student::class);
    }

}
