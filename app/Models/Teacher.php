<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Teacher extends BaseModel {

    protected $primaryKey = "user_id";
    protected $fillable   = [
        "first_name", "last_name", "middle_name", 'birthdate', 'image_url'
    ];

    //
    // <editor-fold defaultstate="collapsed" desc="Static Utility Functions">

    public static function deleteSeeded() {
        $queryString = 'DELETE teachers, users FROM teachers LEFT JOIN users ON teachers.user_id = users.id WHERE users.seeded = ?';
        return DB::delete($queryString, array(1));
    }

    // </editor-fold>
    //
    // <editor-fold defaultstate="collapsed" desc="Relationships">

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function classes() {
        return $this->hasMany(SchoolClass::class);
    }

    // </editor-fold>
    // 
    // <editor-fold defaultstate="collapsed" desc="Event Handlers">

    protected static function boot() {
        parent::boot();

        static::deleting(function($teacher) { // before delete() method call this
            $teacher->user()->delete();
            // do the rest of the cleanup...
        });
    }

    // </editor-fold>
    //    
    // <editor-fold defaultstate="collapsed" desc="Scopes">

    public function scopeAlphabetical($query) {
        return $query->orderBy('first_name');
    }

    // </editor-fold>
}
