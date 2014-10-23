<?php

namespace Academica\Grading;

use Exception;

/**
 * Description of Transmuter
 *
 * @author ervinne
 */
class Transmuter {

    protected $transmutation = NULL;

    public function __construct($transmutation) {
        $this->transmutation = $transmutation;
    }

    public function transmute($baseGrade) {
        foreach ($this->transmutation AS $transmutation) {
            if ($baseGrade >= $transmutation->initial_grade_from &&
                    $baseGrade <= $transmutation->initial_grade_to) {
                return $transmutation->transmuted_grade;
            }
        }

        throw new Exception("Transmutation for grade {$baseGrade} not found");
    }

}
