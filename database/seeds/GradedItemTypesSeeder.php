<?php

use App\Models\GradedItemType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradedItemTypesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("graded_item_types")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gradedItemTypes = [
//            ["name" => "Written Works (MAPEH 20%)", "percentage_value" => 20],
//            ["name" => "Performance Tasks (MAPEH 60%)", "percentage_value" => 60],
//            ["name" => "Quarterly Exams (MAPEH 20%)", "percentage_value" => 20],
//            ["name" => "Written Works (30%)", "percentage_value" => 30],
//            ["name" => "Performance Tasks (30%)", "percentage_value" => 30],
//            ["name" => "Quarterly Exams (40%)", "percentage_value" => 40],
            ["name" => "Written Works (20%)", "percentage_value" => 20],
            ["name" => "Performance Tasks (60%)", "percentage_value" => 60],
            ["name" => "Quarterly Exams (20%)", "percentage_value" => 20]
        ];

        GradedItemType::insert($gradedItemTypes);
    }

}
