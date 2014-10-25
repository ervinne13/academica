<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Academica;

use App\Models\GradedItem;
use App\Models\SchoolClass;
use App\Models\StudentGrade;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Files\ExcelFile;
use function public_path;

/**
 * Description of ClassRecordExcelImport
 *
 * @author ervinne
 */
class ClassRecordExcelImport extends ExcelFile {

    const DESTINATION_PATH = "uploads";

    public function importToDB($classId) {
        $data = $this->get();

//        var_dump($data->toArray());

        $class = SchoolClass::find($classId);

        try {

            DB::beginTransaction();

            for ($i = 4; $i < count($data); $i ++) {
                $this->saveStudentGradeFromImport($data[$i], $class);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $data;
    }

    private function saveStudentGradeFromImport($importRow, $class) {

        foreach ($importRow AS $key => $importCol) {

            //  numeric column keys are the graded items
            //  the column value is the score
            if (is_numeric($key)) {
                $gradedItem = GradedItem::WithHPS($key, $class->id)->first();

                if (!$gradedItem) {
                    continue;
                }

                $hps           = $gradedItem->highest_possible_score;
                $score         = $importCol;
                $computedGrade = ($score / $hps) * 100;

                if ($score !== NULL) {

                    $grade = StudentGrade::firstOrNew([
                                "class_id"       => $class->id,
                                "graded_item_id" => $key,
                                "subject_id"     => $class->subject_id,
                                "student_id"     => $importRow->id
                    ]);

                    $grade->highest_possible_score = $hps;
                    $grade->score                  = $score;
                    $grade->grade                  = $computedGrade;

                    $grade->save();
                }
            }
        }
    }

    // <editor-fold defaultstate="collapsed" desc="File Import Functions">
    public function getFile() {
        $file = Input::file('file');

        $generatedFilename = "";

        if ($file) {
            $extension         = $this->getFileExtension($file->getClientOriginalName());
            $generatedFilename = $this->generateFileName($extension);
            $file->move(public_path(static::DESTINATION_PATH), $generatedFilename);

            return public_path(static::DESTINATION_PATH) . "/" . $generatedFilename;
        } else {
            throw new Exception("No file specified in request");
        }
    }

    private function getFileExtension($fileName) {
        $splittedFileName = explode(".", $fileName);
        return $splittedFileName[count($splittedFileName) - 1];
    }

    private function generateFileName($extension) {
        $fileName = date('Y_m_d_His');
        return "{$fileName}.{$extension}";
    }

    // </editor-fold>   
}
