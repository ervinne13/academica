<?php

namespace Academica;

use App\Models\GradingYear;
use App\Models\Subject;

/**
 * Description of ReportCardFormatter
 *
 * @author ervinne
 */
class ReportCardFormatter {

    protected $subjectSortOrder = [
        "Mother Tounge",
        "Filipino",
        "English",
        "Math",
        "Science",
        "AP",
        "EsP",
        "TLE",
        "MAPEH",
        "Music",
        "Arts",
        "PE",
        "Health"
    ];

    /**
     * TODO: make a dedicated Collection class for grades coming from StudentRecord
     * @param type $grades
     */
    public function format($grades, $studentId, $transmuter) {
        //  get the corresponding subject id of each subject

        $subjects = Subject::EnrolledByStudent($studentId)->get();

        $gradingYear = GradingYear::open()->first();

        $gradingCard = [
            "subjects"        => [],
            "initialGrade"    => 0,
            "transmutedGrade" => 0,
        ];


        //  Complexity O(a(log(b * c)))
        // a
        foreach ($this->subjectSortOrder AS $subjectShortName) {
            //  b
            foreach ($subjects AS $index => $subject) {
                if ($subject->short_name == $subjectShortName) {
                    $subjectAssoc               = [];
                    $subjectAssoc["id"]         = $subject->id;
                    $subjectAssoc["short_name"] = $subject->short_name;
                    $subjectAssoc["name"]       = $subject->name;
                    $subjectAssoc["grades"]     = [];

                    //  c
                    $avgInitialGrade = 0;
                    foreach ($grades AS $periodId => $periodGrades) {
                        if ($gradingYear->currently_active_period_id >= $periodId) {
                            $subjectAssoc["grades"][$periodId] = [
                                "initialGrade"    => $periodGrades[$subject->id]["initialGrade"],
                                "transmutedGrade" => $periodGrades[$subject->id]["transmutedGrade"]
                            ];

                            $avgInitialGrade += $periodGrades[$subject->id]["initialGrade"];
                        } else {
                            $subjectAssoc["grades"][$periodId] = [
                                "initialGrade"    => "",
                                "transmutedGrade" => ""
                            ];
                        }
                    }

                    $subjectAssoc["initialGrade"]    = $avgInitialGrade / $gradingYear->currently_active_period_id;
                    $subjectAssoc["transmutedGrade"] = $transmuter->transmute($subjectAssoc["initialGrade"]);

                    $gradingCard["initialGrade"] += $subjectAssoc["initialGrade"];

                    array_push($gradingCard["subjects"], $subjectAssoc);
                    unset($subjects[$index]);
                }
            }
        }

        $gradingCard["initialGrade"]    = $gradingCard["initialGrade"] / count($subjects);
        $gradingCard["transmutedGrade"] = $transmuter->transmute($gradingCard["initialGrade"]);


        return $gradingCard;
    }

}
