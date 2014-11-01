<?php

use App\Models\Transmutation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransmutationTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("transmutation")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $records = [
            ["initial_grade_from" => 0, "initial_grade_to" => 3.99, "transmuted_grade" => 60],
            ["initial_grade_from" => 4, "initial_grade_to" => 7.99, "transmuted_grade" => 61],
            ["initial_grade_from" => 8, "initial_grade_to" => 11.99, "transmuted_grade" => 62],
            ["initial_grade_from" => 12, "initial_grade_to" => 15.99, "transmuted_grade" => 63],
            ["initial_grade_from" => 16, "initial_grade_to" => 19.99, "transmuted_grade" => 64],
            ["initial_grade_from" => 20, "initial_grade_to" => 23.99, "transmuted_grade" => 65],
            ["initial_grade_from" => 24, "initial_grade_to" => 27.99, "transmuted_grade" => 66],
            ["initial_grade_from" => 28, "initial_grade_to" => 31.99, "transmuted_grade" => 67],
            ["initial_grade_from" => 32, "initial_grade_to" => 35.99, "transmuted_grade" => 68],
            ["initial_grade_from" => 36, "initial_grade_to" => 39.99, "transmuted_grade" => 69],
            ["initial_grade_from" => 40, "initial_grade_to" => 43.99, "transmuted_grade" => 70],
            ["initial_grade_from" => 44, "initial_grade_to" => 47.99, "transmuted_grade" => 71],
            ["initial_grade_from" => 48, "initial_grade_to" => 51.99, "transmuted_grade" => 72],
            ["initial_grade_from" => 52, "initial_grade_to" => 55.99, "transmuted_grade" => 73],
            ["initial_grade_from" => 56, "initial_grade_to" => 59.99, "transmuted_grade" => 74],
            ["initial_grade_from" => 60, "initial_grade_to" => 61.59, "transmuted_grade" => 75],
            ["initial_grade_from" => 61.6, "initial_grade_to" => 63.19, "transmuted_grade" => 76],
            ["initial_grade_from" => 63.2, "initial_grade_to" => 64.79, "transmuted_grade" => 77],
            ["initial_grade_from" => 64.8, "initial_grade_to" => 66.39, "transmuted_grade" => 78],
            ["initial_grade_from" => 66.4, "initial_grade_to" => 67.99, "transmuted_grade" => 79],
            ["initial_grade_from" => 68, "initial_grade_to" => 69.59, "transmuted_grade" => 80],
            ["initial_grade_from" => 69.6, "initial_grade_to" => 71.19, "transmuted_grade" => 81],
            ["initial_grade_from" => 71.2, "initial_grade_to" => 72.79, "transmuted_grade" => 82],
            ["initial_grade_from" => 72.8, "initial_grade_to" => 74.39, "transmuted_grade" => 83],
            ["initial_grade_from" => 74.4, "initial_grade_to" => 75.99, "transmuted_grade" => 84],
            ["initial_grade_from" => 76, "initial_grade_to" => 77.59, "transmuted_grade" => 85],
            ["initial_grade_from" => 77.6, "initial_grade_to" => 79.19, "transmuted_grade" => 86],
            ["initial_grade_from" => 79.2, "initial_grade_to" => 80.79, "transmuted_grade" => 87],
            ["initial_grade_from" => 80.8, "initial_grade_to" => 82.39, "transmuted_grade" => 88],
            ["initial_grade_from" => 82.4, "initial_grade_to" => 83.99, "transmuted_grade" => 89],
            ["initial_grade_from" => 84, "initial_grade_to" => 85.59, "transmuted_grade" => 90],
            ["initial_grade_from" => 85.6, "initial_grade_to" => 87.19, "transmuted_grade" => 91],
            ["initial_grade_from" => 87.2, "initial_grade_to" => 88.79, "transmuted_grade" => 92],
            ["initial_grade_from" => 88.8, "initial_grade_to" => 90.39, "transmuted_grade" => 93],
            ["initial_grade_from" => 90.4, "initial_grade_to" => 91.99, "transmuted_grade" => 94],
            ["initial_grade_from" => 92, "initial_grade_to" => 93.59, "transmuted_grade" => 95],
            ["initial_grade_from" => 93.6, "initial_grade_to" => 95.19, "transmuted_grade" => 96],
            ["initial_grade_from" => 95.2, "initial_grade_to" => 96.79, "transmuted_grade" => 97],
            ["initial_grade_from" => 96.8, "initial_grade_to" => 98.39, "transmuted_grade" => 98],
            ["initial_grade_from" => 98.4, "initial_grade_to" => 99.99, "transmuted_grade" => 99],
            ["initial_grade_from" => 100, "initial_grade_to" => 100, "transmuted_grade" => 100]
        ];

        Transmutation::insert($records);
    }

}
