<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolClass extends BaseModel {

    public $autoUseTransactions = TRUE;
    protected $table            = "classes";
    protected $fillable         = [
        "grading_year_id", "level_id", "subject_id", "teacher_id", "name"
    ];

    public function enroll($studentId) {
        return DB::table("student_classes")->insert([
                    "class_id"   => $this->id,
                    "student_id" => $studentId
        ]);
    }

    public function assignGradedItemsNonTrans($gradedItems) {
        //  clear first
        DB::table('class_graded_items')
                ->where('class_id', $this->id)
                ->delete();

        for ($i = 0; $i < count($gradedItems); $i ++) {
            $gradedItems[$i]["class_id"] = $this->id;
        }

        DB::table('class_graded_items')
                ->insert($gradedItems);
    }

    public function assignGradedItems($gradedItems) {

        try {

            if ($autoUseTransactions) {
                DB::beginTransaction();
            }

            //  clear first
            DB::table('class_graded_items')
                    ->where('class_id', $this->id)
                    ->delete();

            DB::table('class_graded_items')
                    ->insert($gradedItems);

            if ($autoUseTransactions) {
                DB::commit();
            }
        } catch (Exception $e) {
            if ($autoUseTransactions) {
                DB::rollBack();
            }
            throw $e;
        }
    }

    public function assignGradedItem($gradedItemId, $hps) {

        $existingRecord = DB::table('class_graded_items')
                ->where('class_id', $this->id)
                ->where('graded_item_id', $gradedItemId)
                ->first();

        if ($existingRecord) {
            DB::table('class_graded_items')
                    ->where('class_id', $this->id)
                    ->where('graded_item_id', $gradedItemId)
                    ->update('highest_possible_score', $hps);
        } else {
            $record = [
                "class_id"               => $this->id,
                "graded_item_id"         => $gradedItemId,
                "highest_possible_score" => $hps,
            ];

            DB::table('class_graded_items')->insert($record);
        }
    }

    // <editor-fold defaultstate="collapsed" desc="Relationships">

    public function gradingYear() {
        return $this->belongsTo(GradingYear::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function students() {
        return $this->manyThroughMany(Student::class, StudentClass::class, 'class_id', 'id', 'student_id');
    }

    // </editor-fold>
}
