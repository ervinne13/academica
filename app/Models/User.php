<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    const ROLE_ADMIN   = 'ADMIN';
    const ROLE_TEACHER = 'TEACHER';
    const ROLE_VIEWER  = 'VIEWER';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_active', 'role_name', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //
    // <editor-fold defaultstate="collapsed" desc="Utility Functions">

    public function isAdmin() {
        return $this->role_name == static::ROLE_ADMIN;
    }

    public function isTeacher() {
        return $this->role_name == static::ROLE_TEACHER;
    }

    // </editor-fold>
    //
    // <editor-fold defaultstate="collapsed" desc="Relationships">

    public function teacher() {
        return $this->hasOne(Teacher::class);
    }

    // </editor-fold>
    // 
    // <editor-fold defaultstate="collapsed" desc="Event Handlers">

    protected static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
            $user->teacher()->delete();
            // do the rest of the cleanup...
        });
    }

    // </editor-fold>
}
