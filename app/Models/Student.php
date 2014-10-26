<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model {

    protected $fillable = [
        "is_active", "lrn", "student_number",
        "first_name",
        "middle_name",
        "last_name",
        "birthdate",
        "contact_number_1",
        "contact_number_2",
        "landline",
        "address",
        "image_url",
    ];

    public static function GetKeywordMatchSize($keyword, $classId) {
        $query = DB::table('students')
                ->select(DB::raw('count(*) as match_count'));

        $query->where(function($query) use ($keyword) {
            $query->where('lrn', 'LIKE', "%{$keyword}%");
            $query->orWhere('student_number', 'LIKE', "%{$keyword}%");
            $query->orWhere('first_name', 'LIKE', "%{$keyword}%");
            $query->orWhere('last_name', 'LIKE', "%{$keyword}%");
            $query->orWhereRaw("concat(first_name, \" \" , last_name) LIKE '%?%'", [$keyword]);
        })
        ;

        if ($classId) {
            $query->leftJoin('student_classes', function($join) use ($classId) {
                $join->on('student_classes.student_id', '=', 'students.id');
                $join->on('student_classes.class_id', '=', DB::raw("'{$classId}'"));
            });
            $query->whereRaw('student_classes.class_id IS NULL', []);
        }

        $result = $query->first();
        return $result->match_count;
    }

    // <editor-fold defaultstate="collapsed" desc="Scopes">

    public function scopeDatatable($query) {
        return $query
                        ->select(['students.*', 'sections.name AS section_name'])
                        ->leftJoin('section_students', 'student_id', '=', 'students.id')
                        ->leftJoin('sections', 'section_id', '=', 'sections.id')
        ;
    }

    public function scopeKeyword($query, $keyword, $classId, $offset, $fetchCount) {
        $query
                ->where(function($query) use ($keyword) {
                    $query->where('lrn', 'LIKE', "%{$keyword}%");
                    $query->orWhere('student_number', 'LIKE', "%{$keyword}%");
                    $query->orWhere('first_name', 'LIKE', "%{$keyword}%");
                    $query->orWhere('last_name', 'LIKE', "%{$keyword}%");
                    $query->orWhereRaw("concat(first_name, \" \" , last_name) LIKE '%?%'", [$keyword]);
                });

        if ($classId) {
            $query->leftJoin('student_classes', function($join) use ($classId) {
                $join->on('student_classes.student_id', '=', 'students.id');
                $join->on('student_classes.class_id', '=', DB::raw("'{$classId}'"));
            });
            $query->whereRaw('student_classes.class_id IS NULL', []);
        }

        $query
                ->orderBy('first_name')
                ->offset($offset)
                ->limit($fetchCount);

        return $query;
    }

    public function scopeEnrolledInClass($query, $classId) {
        return $query
                        ->join('student_classes AS sc', 'sc.student_id', '=', 'students.id')
                        ->where('class_id', $classId);
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
