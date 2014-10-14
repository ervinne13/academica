<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

    // <editor-fold defaultstate="collapsed" desc="Scopes">

    public function scopeDatatable($query) {
        return $query
                ->select(['students.*', 'sections.name AS section_name'])
                        ->leftJoin('section_students', 'student_id', '=', 'students.id')
                        ->leftJoin('sections', 'section_id', '=', 'sections.id')
        ;
    }

    // </editor-fold>
    //
    // <editor-fold defaultstate="collapsed" desc="Accessors & Mutators">

    /**
     * To use: $student->full_name
     * Get the student's full name by combining first name and last name.
     *     
     * @return string
     */
    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }

    // </editor-fold>
}
