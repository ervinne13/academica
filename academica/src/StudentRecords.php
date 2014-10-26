<?php

namespace Academica;

/**
 * Description of StudentRecords
 *
 * @author ervinne
 */
class StudentRecords {

    /**
     * A collection of Academica\SubjectGrades     
     * @var Array
     */
    protected $subjectGradesCollection;

    public function __construct() {
        $this->subjectGradesCollection = [];
    }

    public function toArray() {
        $subjectGrades = [];

        foreach ($this->subjectGradesCollection AS $grade) {
            array_push($subjectGrades, $grade->toArray());
        }

        return $subjectGrades;
    }

    public function __toString() {
        return json_encode($this->toArray());
    }

    // <editor-fold defaultstate="collapsed" desc="Mutators & Accessors">

    public function getSubjectGradesCollection() {
        return $this->subjectGradesCollection;
    }

    public function setSubjectGradesCollection(Array $subjectGradesCollection) {
        $this->subjectGradesCollection = $subjectGradesCollection;
    }

    public function addSubjectGrades(SubjectGrades $subjectGrades) {
        array_push($this->subjectGradesCollection, $subjectGrades);
    }

    // </editor-fold>    
}
