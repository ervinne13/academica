<?php

use App\Models\GradedItem;
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

        $MAPEHSubjects = [
            "Music", "Arts", "PE", "Health"
        ];

        $writtenWorks = [
            ["Q1", "Quiz 1"],
            ["Q2", "Quiz 2"],
            ["Q3", "Quiz 3"],
            ["A1", "Assignment 1"],
            ["A2", "Assignment 2"],
            ["A3", "Assignment 3"],
            ["LT", "Long Test"],
        ];

        $performance = [
            ["T1", "Task 1"],
            ["T2", "Task 2"]
        ];

        $quarterlyExam = [
            ["PT", "Periodical Test"]
        ];

        foreach ($gradingPeriods AS $gradingPeriod) {
            foreach ($gradedItemTypes AS $itemType) {
                foreach ($subjects AS $subject) {

                    $gradedItem = [
                        "subject_id"        => $subject->id,
                        "type_id"           => $itemType->id,
                        "grading_period_id" => $gradingPeriod->id,
                    ];

                    foreach ($writtenWorks AS $writtenWork) {
                        $gradedItem["short_name"] = $writtenWork[0];
                        $gradedItem["name"]       = "P-{$gradingPeriod->short_name} {$subject->short_name} $writtenWork[1]";

                        array_push($gradedItems, $gradedItem);
                    }

                    foreach ($performance AS $performanceItem) {
                        $gradedItem["short_name"] = $performanceItem[0];
                        $gradedItem["name"]       = "P-{$gradingPeriod->short_name} {$subject->short_name} $performanceItem[1]";

                        array_push($gradedItems, $gradedItem);
                    }

                    foreach ($quarterlyExam AS $exam) {
                        $gradedItem["short_name"] = $exam[0];
                        $gradedItem["name"]       = "P-{$gradingPeriod->short_name} {$subject->short_name} $exam[1]";

                        array_push($gradedItems, $gradedItem);
                    }
                }
            }
        }

        GradedItem::insert($gradedItems);
    }

    public function old_run_20161022() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table("graded_items")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gradedItems     = [];
        $gradedItemTypes = GradedItemType::all();
        $gradingPeriods  = GradingPeriod::all();
        $subjects        = Subject::all();

        $MAPEHSubjects = [
            "Music", "Arts", "PE", "Health"
        ];

        $writtenWorks = [
            ["Q1", "Quiz 1"],
            ["Q2", "Quiz 2"],
            ["Q3", "Quiz 3"],
            ["A1", "Assignment 1"],
            ["A2", "Assignment 2"],
            ["A3", "Assignment 3"],
            ["LT", "Long Test"],
        ];

        $performance = [
            ["T1", "Task 1"],
            ["T2", "Task 2"]
        ];

        $quarterlyExam = [
            ["PT", "Periodical Test"]
        ];

        foreach ($gradingPeriods AS $gradingPeriod) {
            foreach ($gradedItemTypes AS $itemType) {
                foreach ($subjects AS $subject) {

                    $gradedItem = null;

                    if (str_contains($itemType->name, "MAPEH")) {
                        //  only register mapeh subjects on mapeh grading item types
                        if (in_array($subject->short_name, $MAPEHSubjects)) {
                            $gradedItem = [
                                "subject_id"        => $subject->id,
                                "type_id"           => $itemType->id,
                                "grading_period_id" => $gradingPeriod->id,
                            ];
                        }
                    } else {
                        $gradedItem = [
                            "subject_id"        => $subject->id,
                            "type_id"           => $itemType->id,
                            "grading_period_id" => $gradingPeriod->id,
                        ];
                    }

                    if ($gradedItem) {
                        foreach ($writtenWorks AS $writtenWork) {
                            $gradedItem["short_name"] = $writtenWork[0];
                            $gradedItem["name"]       = "P-{$gradingPeriod->short_name} {$subject->short_name} $writtenWork[1]";

                            array_push($gradedItems, $gradedItem);
                        }

                        foreach ($performance AS $performanceItem) {
                            $gradedItem["short_name"] = $performanceItem[0];
                            $gradedItem["name"]       = "P-{$gradingPeriod->short_name} {$subject->short_name} $performanceItem[1]";

                            array_push($gradedItems, $gradedItem);
                        }

                        foreach ($quarterlyExam AS $exam) {
                            $gradedItem["short_name"] = $exam[0];
                            $gradedItem["name"]       = "P-{$gradingPeriod->short_name} {$subject->short_name} $exam[1]";

                            array_push($gradedItems, $gradedItem);
                        }
                    }
                }
            }
        }

        GradedItem::insert($gradedItems);
    }

}
