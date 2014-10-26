<?php

namespace Academica;

use Academica\Grading\Transmuter;
use App\Models\SchoolClass;
use App\Models\Subject;

/**
 * Description of SubjectGrades
 *
 * @author ervinne
 */
class SubjectGrades {

    /** @var Subject */
    protected $subject;

    /** @var SchoolClass */
    protected $class;

    /**
     * Key-Value pair for graded items and their score.
     * Used for quick lookup of graded item score
     * @var Array 
     */
    protected $gradedItemMap;

    /**
     * A map of App\Models\GradedItemType with their corresponding App\Models\GradedItem.
     * @var Array
     */
    protected $categorizedGradedItemCollection;

    /**
     * A map containing the total score, percentage score, and weighed score for each
     * graded item types / category
     * @var Array
     */
    protected $gradedItemTypeSummaryMap;

    /**
     * This represents the current percentage weight of the whole subject grade.
     * This is useful for computing ONGOING grades and what weight they hold.
     * Ex. if the current subject only has 2 quizzes so far under written works 20%
     * then the total percentage weight is only at 20%. That means that the initial
     * grade computed only holds 20% of the actual initial grade upon completion of
     * subject.
     * @var Float 
     */
    protected $totalPercentageWeight;

    /** @var Float */
    protected $initialGrade;

    /** @var Integer */
    protected $transmutedGrade;

    /** @var Transmuter */
    protected $transmuter;

    public function toArray() {
        return [
            "subject"                         => $this->subject,
            "class"                           => $this->class,
            "gradedItemMap"                   => $this->gradedItemMap,
            "categorizedGradedItemCollection" => $this->categorizedGradedItemCollection,
            "gradedItemTypeSummaryMap"        => $this->gradedItemTypeSummaryMap,
            "initialGrade"                    => $this->initialGrade,
            "transmutedGrade"                 => $this->transmutedGrade,
        ];
    }

    public function autoTransmute($transmuter) {
        $this->transmuter = $transmuter;
    }

    /**
     * @param Array $gradedItems an array of App\Models\GradedItem
     * @param Array $grades an array of App\Models\StudentGrades
     */
    public function produce($gradedItems, $grades) {

        //  Complexity: O(a + b + c)
        $this->gradedItemMap            = [];
        $this->gradedItemTypeSummaryMap = [];

        $this->totalPercentageWeight = 0;

        //  create a grade map first to reduce complexity from O(a^2) to O(a + b + c)
        //  Process a
        foreach ($gradedItems AS $gradedItem) {
            $this->gradedItemMap[$gradedItem->id] = $gradedItem->toArray();

            if (!array_key_exists($gradedItem->type_id, $this->gradedItemTypeSummaryMap)) {
                $this->gradedItemTypeSummaryMap[$gradedItem->type_id] = [
                    "total"  => 0,
                    "hps"    => 0,
                    "weight" => $gradedItem->type->percentage_value
                ];

                $this->totalPercentageWeight += $gradedItem->type->percentage_value;
            }

            $this->gradedItemTypeSummaryMap[$gradedItem->type_id]["hps"] += $gradedItem->highest_possible_score;
        }

        //  Process b
        foreach ($grades AS $grade) {
            //  only add those existing in the gradedItemMap so inactive grades won't be added
            if (array_key_exists($grade->graded_item_id, $this->gradedItemMap)) {
                $this->gradedItemMap[$grade->graded_item_id]["score"] = $grade->score;
                $this->gradedItemMap[$grade->graded_item_id]["grade"] = $grade->grade;

                $this->gradedItemTypeSummaryMap[$grade->gradedItem->type_id]["total"] += $grade->score;
            }
        }

        //  Process c        
        $this->initialGrade = 0;
        foreach ($this->gradedItemTypeSummaryMap AS $gradedItemTypeId => $summary) {
            $ps = $summary["total"] / $summary["hps"] * 100;
            $ws = ($summary["weight"] / 100) * $ps;

            $this->gradedItemTypeSummaryMap[$gradedItemTypeId]["ps"] = $ps;
            $this->gradedItemTypeSummaryMap[$gradedItemTypeId]["ws"] = $ws;

            //  $current actual weight computes the weight of the graded item
            //  at current completion of the subject.
            //  ex. in the subject, there is only written works (20%) and performance
            //  tasks (60%), current actual weight will get the weight of 20% and 60%
            //  in order to create an initial grade
            $currentActualWeight = $summary["weight"] / $this->totalPercentageWeight * 100;

            $this->initialGrade += ($currentActualWeight / 100) * $ps;
        }

        if ($this->transmuter) {
            $this->transmutedGrade = $this->transmuter->transmute($this->initialGrade);
        }
    }

    // <editor-fold defaultstate="collapsed" desc="Mutators & Accessors">
    public function getSubject() {
        return $this->subject;
    }

    public function getClass() {
        return $this->class;
    }

    public function getGradedItemMap() {
        return $this->gradedItemMap;
    }

    public function getCategorizedGradedItemCollection() {
        return $this->categorizedGradedItemCollection;
    }

    public function getGradedItemTypeSummaryMap() {
        return $this->gradedItemTypeSummaryMap;
    }

    public function getInitialGrade() {
        return $this->initialGrade;
    }

    public function getTransmutedGrade() {
        return $this->transmutedGrade;
    }

    public function setSubject(Subject $subject) {
        $this->subject = $subject;
    }

    public function setClass(SchoolClass $class) {
        $this->class = $class;
    }

    public function setGradedItemMap(Array $gradedItemMap) {
        $this->gradedItemMap = $gradedItemMap;
    }

    public function getGradedItemsFromCategorizedGradedItemCollection() {

        $gradedItems = [];

        foreach ($this->categorizedGradedItemCollection AS $gradedItemType) {
            array_push($gradedItems, $gradedItemType->gradedItems);
        }

        return $gradedItems;
    }

    public function setCategorizedGradedItemCollection(Array $categorizedGradedItemCollection) {
        $this->categorizedGradedItemCollection = $categorizedGradedItemCollection;
    }

    public function setGradedItemTypeSummaryMap(Array $gradedItemTypeSummaryMap) {
        $this->gradedItemTypeSummaryMap = $gradedItemTypeSummaryMap;
    }

    public function setInitialGrade(Float $initialGrade) {
        $this->initialGrade = $initialGrade;
    }

    public function setTransmutedGrade(Integer $transmutedGrade) {
        $this->transmutedGrade = $transmutedGrade;
    }

// </editor-fold>
}
