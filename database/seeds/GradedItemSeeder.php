<?php

use App\Models\GradedItemType;
use App\Models\GradingPeriod;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradedItemSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("graded_items")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gradedItems     = [];
        $gradedItemTypes = GradedItemType::all();
        $gradingPeriods  = GradingPeriod::all();
        $subjects        = Subject::all();
        
        //  TODO: finish this
        
    }

}
