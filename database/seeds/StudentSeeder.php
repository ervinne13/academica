<?php

use App\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Student::where('seeded', 1)->delete();

        $possibleImages = [
            "2016_10_04_114544.jpg",
            "2016_10_05_022200.jpg",
            "2016_10_05_022210.jpg",
            "2016_10_05_022212.jpg",
            "2016_10_05_022214.jpg",
            "2016_10_05_022216.jpg",
            "2016_10_05_022218.jpg",
        ];

        for ($i = 0; $i < 100; $i++) {
            $faker                     = Factory::create();
            $student                   = new Student();
            $student->seeded           = 1;
            $student->lrn              = $faker->randomNumber(9) . "" . $faker->randomNumber(3);
            $student->student_number   = "SN-" . date('Y') . "-" . $faker->randomNumber(7);
            $student->first_name       = $faker->firstName;
            $student->last_name        = $faker->lastName;
            $student->middle_name      = strtoupper($faker->randomLetter);
            $student->birthdate        = $faker->dateTimeThisDecade->format("Y-m-d");
            $student->address          = $faker->address;
            $student->contact_number_1 = $faker->phoneNumber;
            $student->contact_number_2 = $faker->phoneNumber;

            $student->image_url = "/uploads/" . $possibleImages[$faker->randomKey($possibleImages)];

            $student->save();
        }
    }

}
