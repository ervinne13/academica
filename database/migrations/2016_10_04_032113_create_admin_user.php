<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUser extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $user            = new User();
        $user->name      = "Administrator";
        $user->username  = "administrator";
        $user->role_name = User::ROLE_ADMIN;
        $user->password  = \Hash::make("password");

        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        User::where("username", "administrator")->delete();
    }

}
