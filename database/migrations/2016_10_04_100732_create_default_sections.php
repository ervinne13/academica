<?php

use App\Models\Level;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateDefaultSections extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        $levels   = Level::all();
        $sections = [
            "Section 1",
            "Section 2",
            "Section 3",
            "Section 4",
            "Section 5",
            "Section 6",
        ];

        try {
            DB::beginTransaction();

            foreach ($levels AS $level) {
                $insertableSections = [];
                foreach ($sections AS $section) {
                    array_push($insertableSections, [
                        "level_id" => $level->id,
                        "name"     => $section
                    ]);
                }

                Section::insert($insertableSections);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("sections")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
