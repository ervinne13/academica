<?php

namespace Academica;

use App\Models\GradingPeriod;
use App\Models\GradingYear;
use App\Models\Student;
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
        "others",
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

        $student         = Student::find($studentId);
        $studentSections = $student->sections;

        $periods = GradingPeriod::all();

        if (count($studentSections) > 0) {
            $subject = Subject::EnrolledByStudentOnSection($studentId, $studentSections[0]->section_id)->get();
        } else {
            $subject = Subject::EnrolledByStudentOpenYear($studentId)->get();
        }
        $subjectCount = count($subject);

        $gradingYear = GradingYear::open()->first();

        $gradingCard = [
            "subjects"             => [],
            "totalTransmutedGrade" => 0,
            "transmutedGrade"      => 0,
        ];
        
        $mapehSubjects = [];

        //  Complexity O(a(log(b * c)))
        // a
        foreach ($this->subjectSortOrder AS $subjectShortName) {
            //  b
            foreach ($subject AS $index => $period) {
                if ($period->short_name == $subjectShortName || ($subjectShortName == "others" && !in_array($period->short_name, $this->subjectSortOrder))) {
                    $subjectAssoc                 = [];
                    $subjectAssoc["id"]           = $period->id;
                    $subjectAssoc["short_name"]   = $period->short_name;
                    $subjectAssoc["teacher_id"]   = $period->teacher_id;
                    $subjectAssoc["teacher_name"] = $period->teacher_name;
                    $subjectAssoc["name"]         = $period->name;
                    $subjectAssoc["grades"]       = [];

                    $subjectTotalGrade = 0;
                    foreach ($grades AS $periodId => $periodGrades) {
                        if ($gradingYear->currently_active_period_id >= $periodId) {
                            $subjectAssoc["grades"][$periodId] = [
                                "initialGrade"    => $periodGrades[$period->id]["initialGrade"],
                                "transmutedGrade" => $periodGrades[$period->id]["transmutedGrade"]
                            ];

                            $subjectTotalGrade += $periodGrades[$period->id]["transmutedGrade"];
                        } else {
                            $subjectAssoc["grades"][$periodId] = [
                                "initialGrade"    => "",
                                "transmutedGrade" => ""
                            ];
                        }

                        if (in_array($subjectAssoc["short_name"], $this->mapehSubjects)) {
                            if (!array_key_exists($periodId, $mapehSubjects)) {
                                $mapehSubjects[$periodId] = [];

                                $mapehSubjects[$periodId]["totalTransmutedGrade"] = 0;
                            }

                            if (!array_key_exists($subjectAssoc["short_name"], $mapehSubjects[$periodId])) {
                                $mapehSubjects[$periodId][$subjectAssoc["short_name"]] = [];
                            }

                            $mapehTransmutedGrade = $transmuter->transmute($subjectAssoc["grades"][$periodId]["initialGrade"]);

                            $mapehSubjects[$periodId][$subjectAssoc["short_name"]] = [
                                "name"            => $subjectAssoc["name"],
                                "initialGrade"    => $subjectAssoc["grades"][$periodId]["initialGrade"],
                                "transmutedGrade" => $mapehTransmutedGrade
                            ];
                            $mapehSubjects[$periodId]["totalTransmutedGrade"] += $mapehTransmutedGrade;
                        }
                    }

                    $subjectAssoc["transmutedGrade"] = $subjectTotalGrade / $gradingYear->currently_active_period_id;
                    $gradingCard["totalTransmutedGrade"] += $subjectAssoc["transmutedGrade"];

                    array_push($gradingCard["subjects"], $subjectAssoc);
                    unset($subject[$index]);
                }
            }
        }

        $gradingCard["transmutedGrade"] = number_format($subjectCount > 0 ? $gradingCard["totalTransmutedGrade"] / $subjectCount : 0, 2);

        $rankedSubjects = $gradingCard["subjects"];

        usort($rankedSubjects, function($a, $b) {
            return $a["transmutedGrade"] <= $b["transmutedGrade"];
        });

        $gradingCard["subjectsRanked"]       = $rankedSubjects;
        $gradingCard["mapehSubjectsSummary"] = $mapehSubjects;

        $gradedPeriodCount    = 0;
        $gradingCard["mapeh"] = [
            "totalTransmutedGrade" => 0
        ];

        foreach ($periods AS $period) {
            if ($gradingYear->currently_active_period_id >= $period->id) {

                $gradingCard["mapeh"][$period->id] = ["transmutedGrade" => 0];

                if (count($mapehSubjects) > 0) {
                    $gradingCard["mapeh"][$period->id]["transmutedGrade"] = $mapehSubjects[$period->id]["totalTransmutedGrade"] / count($mapehSubjects);

                    $gradingCard["mapeh"]["totalTransmutedGrade"] += $gradingCard["mapeh"][$period->id]["transmutedGrade"];

                    //  after applying total transmuted grade, round off the transmuted grade
                    $gradingCard["mapeh"][$period->id]["transmutedGrade"] = number_format($gradingCard["mapeh"][$period->id]["transmutedGrade"]);

                    $gradedPeriodCount ++;
                }
            } else {
                $gradingCard["mapeh"][$period->id] = [
                    "initialGrade"    => "",
                    "transmutedGrade" => ""
                ];
            }
        }

        if (count($mapehSubjects) > 0) {
            $gradingCard["mapeh"]["transmutedGrade"] = number_format($gradingCard["mapeh"]["totalTransmutedGrade"] / $gradedPeriodCount);
        }

        //  format all grades only after all computations are properly set

        for ($i = 0; $i < count($gradingCard["subjects"]); $i ++) {

            foreach ($gradingCard["subjects"][$i]["grades"] AS $gradingPeriod => $grade) {
                $rawGrade = $gradingCard["subjects"][$i]["grades"][$gradingPeriod]["transmutedGrade"];
                if ($rawGrade) {
                    $gradingCard["subjects"][$i]["grades"][$gradingPeriod]["transmutedGrade"] = number_format($rawGrade);
                }
            }

            $rawGrade = $gradingCard["subjects"][$i]["transmutedGrade"];
            if ($rawGrade) {
                $gradingCard["subjects"][$i]["transmutedGrade"] = number_format($rawGrade);
            }
        }

//        echo json_encode($gradingCard);
//        exit();

        return $gradingCard;
    }

}
