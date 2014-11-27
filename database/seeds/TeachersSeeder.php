<?php

use App\Models\Teacher;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TeachersSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Teacher::deleteSeeded();
        for ($i = 0; $i < 25; $i++) {
            $faker = Factory::create();

            $firstName = $faker->firstName;
            $lastName  = $faker->lastName;

            $user            = new User();
            $user->seeded    = 1;
            $user->role_name = User::ROLE_TEACHER;
            $user->username  = str_replace(" ", "", "{$firstName}{$lastName}"); //  remove possible blanks from first name
            $user->name      = "{$firstName} {$lastName}";
            $user->password  = \Hash::make("password");

            $user->save();

            $teacher              = new Teacher();
            $teacher->user_id     = $user->id;
            $teacher->first_name  = $firstName;
            $teacher->last_name   = $lastName;
            $teacher->middle_name = strtoupper($faker->randomLetter);
            $teacher->birthdate   = $faker->dateTimeThisDecade->format("Y-m-d");

            $teacher->save();
        }
    }

}
