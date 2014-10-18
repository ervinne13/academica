<?php

use App\Models\GradedItem;
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
            ["name" => "Written Works (20%)", "percentage_value" => 20],
            ["name" => "Performance Tasks 60% (MAPEH)", "percentage_value" => 60],
            ["name" => "Quarterly Exams (20%) (MAPEH)", "percentage_value" => 20],
        ];

        GradedItem::insert($gradedItemTypes);
    }

}
