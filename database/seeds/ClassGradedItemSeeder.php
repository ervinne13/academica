<?php

use App\Models\GradedItem;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassGradedItemSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("class_graded_items")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $joinRecords = DB::table('graded_items')
                ->select(['classes.id AS class_id', 'classes.name AS class_name', 'graded_items.id AS graded_item_id', 'graded_items.name AS graded_item_name', 'graded_items.short_name AS graded_item_short_name'])
                ->leftJoin('classes', 'classes.subject_id', '=', 'graded_items.subject_id')
                ->get();

        try {

            DB::beginTransaction();

            foreach ($joinRecords AS $record) {

                $hps = 0;

                switch ($record->graded_item_short_name) {
                    case "Q1":
                    case "Q2":
                    case "Q3": $hps = 30;
                        break;
                    case "A1": $hps = 10;
                        break;
                    case "LT": $hps = 50;
                        break;
                    case "T1": $hps = 100;
                        break;
                    case "T2": $hps = 100;
                        break;
                    case "PT": $hps = 50;
                        break;
                }

                DB::table('class_graded_items')->insert([
                    "class_id"               => $record->class_id,
                    "graded_item_id"         => $record->graded_item_id,
                    "is_active"              => 0,
                    "highest_possible_score" => $hps
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
