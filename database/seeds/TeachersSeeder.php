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

            $user            = new User();
            $user->seeded    = 1;
            $user->role_name = User::ROLE_TEACHER;
            $user->email     = $faker->email;
            $user->name      = "{$faker->firstName} {$faker->lastName}";
            $user->password  = \Hash::make("password");

            $user->save();

            $teacher              = new Teacher();
            $teacher->user_id     = $user->id;
            $teacher->first_name  = $faker->firstName;
            $teacher->last_name   = $faker->lastName;
            $teacher->middle_name = strtoupper($faker->randomLetter);
            $teacher->birthdate   = $faker->dateTimeThisDecade->format("Y-m-d");

            $teacher->save();
        }
    }

}
