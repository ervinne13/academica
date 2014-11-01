<?php

namespace Academica;

use Illuminate\Support\Facades\DB;

/**
 * Description of SectionStudentRankProvider
 *
 * @author ervinne
 */
class SectionStudentRankProvider {

    public function getStudentsRanked($sectionId) {

        $gradedItemTypes = DB::select('
            SELECT 
                    git.id, git.name, sg.student_id, 
                    (SELECT (
                                    SUM(sg.grade) / COUNT(sg.grade) *  git.percentage_value / 100
                            )
                    ) AS computed_grade
            FROM student_grades AS sg
            LEFT JOIN class_graded_items AS cgi ON sg.graded_item_id = cgi.graded_item_id
            LEFT JOIN graded_items AS gi ON gi.id = sg.graded_item_id
            LEFT JOIN graded_item_types AS git ON git.id = gi.type_id
            LEFT JOIN section_classes AS sc ON sc.class_id = cgi.class_id
            WHERE datetaken IS NOT NULL AND sc.section_id = ?
            GROUP BY git.id, git.name, git.percentage_value, sg.student_id', [$sectionId]);

        $studentTotalGrades = [];

        foreach ($gradedItemTypes AS $gradedItemType) {
            if (array_key_exists($gradedItemType->student_id, $studentTotalGrades)) {
                $studentTotalGrades[$gradedItemType->student_id]["grade"] += $gradedItemType->computed_grade;
            } else {
                $studentTotalGrades[$gradedItemType->student_id] = [
                    "student_id" => $gradedItemType->student_id,
                    "grade"      => $gradedItemType->computed_grade
                ];
            }
        }

        usort($studentTotalGrades, function($a, $b) {
            //  rank in reverse
            return $a ["grade"] < $b["grade"];
        });        
        
        return $studentTotalGrades;
    }

//    function studentGradeSorter($a, $b) {
//        return $a ["grade"] > $b["grade"];
//    }

}
