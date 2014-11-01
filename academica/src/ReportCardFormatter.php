<?php

namespace Academica;

use App\Models\GradingPeriod;
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
    protected $mapehSubjects    = [
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

        $periods      = GradingPeriod::all();
        $subject      = Subject::EnrolledByStudentOpenYear($studentId)->get();
        $subjectCount = count($subject);

        $gradingYear = GradingYear::open()->first();

        $gradingCard = [
            "subjects"        => [],
            "initialGrade"    => 0,
            "transmutedGrade" => 0,
        ];

        $mapehSubjects = [];

        //  Complexity O(a(log(b * c)))
        // a
        foreach ($this->subjectSortOrder AS $subjectShortName) {
            //  b
            foreach ($subject AS $index => $periodSubject) {
                if ($periodSubject->short_name == $subjectShortName) {
                    $subjectAssoc                 = [];
                    $subjectAssoc["id"]           = $periodSubject->id;
                    $subjectAssoc["short_name"]   = $periodSubject->short_name;
                    $subjectAssoc["teacher_id"]   = $periodSubject->teacher_id;
                    $subjectAssoc["teacher_name"] = $periodSubject->teacher_name;
                    $subjectAssoc["name"]         = $periodSubject->name;
                    $subjectAssoc["grades"]       = [];

                    //  c
                    $avgInitialGrade = 0;
                    foreach ($grades AS $periodId => $periodGrades) {
                        if ($gradingYear->currently_active_period_id >= $periodId) {
                            $subjectAssoc["grades"][$periodId] = [
                                "initialGrade"    => $periodGrades[$periodSubject->id]["initialGrade"],
                                "transmutedGrade" => $periodGrades[$periodSubject->id]["transmutedGrade"]
                            ];

                            $avgInitialGrade += $periodGrades[$periodSubject->id]["initialGrade"];
                        } else {
                            $subjectAssoc["grades"][$periodId] = [
                                "initialGrade"    => "",
                                "transmutedGrade" => ""
                            ];
                        }

                        if (in_array($subjectAssoc["short_name"], $this->mapehSubjects)) {
                            if (!array_key_exists($periodId, $mapehSubjects)) {
                                $mapehSubjects[$periodId] = [];
                            }

                            if (!array_key_exists($subjectAssoc["short_name"], $mapehSubjects[$periodId])) {
                                $mapehSubjects[$periodId][$subjectAssoc["short_name"]] = [];
                            }

                            $mapehSubjects[$periodId][$subjectAssoc["short_name"]] = [
                                "name"            => $subjectAssoc["name"],
                                "initialGrade"    => $subjectAssoc["grades"][$periodId]["initialGrade"],
                                "transmutedGrade" => $transmuter->transmute($subjectAssoc["grades"][$periodId]["initialGrade"])
                            ];
                        }
                    }

                    $subjectAssoc["initialGrade"]    = $avgInitialGrade / $gradingYear->currently_active_period_id;
                    $subjectAssoc["transmutedGrade"] = $transmuter->transmute($subjectAssoc["initialGrade"]);

                    $gradingCard["initialGrade"] += $subjectAssoc["initialGrade"];

                    array_push($gradingCard["subjects"], $subjectAssoc);
                    unset($subject[$index]);
                }
            }
        }

        $gradingCard["initialGrade"]    = $subjectCount > 0 ? $gradingCard["initialGrade"] / $subjectCount : 0;
        $gradingCard["transmutedGrade"] = $transmuter->transmute($gradingCard["initialGrade"]);

        $rankedSubjects = $gradingCard["subjects"];

        usort($rankedSubjects, function($a, $b) {
            return $a["initialGrade"] <= $b["initialGrade"];
        });

        $gradingCard["subjectsRanked"]       = $rankedSubjects;
        $gradingCard["mapehSubjectsSummary"] = $mapehSubjects;

        $gradedPeriodCount    = 0;
        $gradingCard["mapeh"] = [
            "initialGrade" => 0
        ];

        foreach ($periods AS $periodSubject) {
            if ($gradingYear->currently_active_period_id >= $periodSubject->id) {
                foreach ($mapehSubjects AS $mapehPeriodSubjects) {
                    if (!array_key_exists($periodSubject->id, $gradingCard["mapeh"])) {
                        $gradingCard["mapeh"][$periodSubject->id] = [
                            "initialGrade" => 0
                        ];
                    }

                    foreach ($mapehPeriodSubjects AS $subject) {
                        $gradingCard["mapeh"][$periodSubject->id]["initialGrade"] += $subject["initialGrade"];
                    }
                }

//                if (!array_key_exists($period->id, $gradingCard["mapeh"])) {
//                    $gradingCard["mapeh"][$period->id] = [
//                        "initialGrade" => 0
//                    ];
//                }

                if (count($mapehSubjects) > 0) {
                    $gradingCard["mapeh"][$periodSubject->id]["initialGrade"]    = $gradingCard["mapeh"][$periodSubject->id]["initialGrade"] / count($mapehSubjects);
                    $gradingCard["mapeh"][$periodSubject->id]["transmutedGrade"] = $transmuter->transmute($gradingCard["mapeh"][$periodSubject->id]["initialGrade"]);

                    $gradingCard["mapeh"]["initialGrade"] += $gradingCard["mapeh"][$periodSubject->id]["initialGrade"];
                    $gradedPeriodCount ++;
                }
            } else {
                $gradingCard["mapeh"][$periodSubject->id] = [
                    "initialGrade"    => "",
                    "transmutedGrade" => ""
                ];
            }
        }

        if (count($mapehSubjects) > 0) {
            $gradingCard["mapeh"]["initialGrade"]    = $gradingCard["mapeh"]["initialGrade"] / $gradedPeriodCount;
            $gradingCard["mapeh"]["transmutedGrade"] = $transmuter->transmute($gradingCard["mapeh"]["initialGrade"]);
        }

        return $gradingCard;
    }

}
