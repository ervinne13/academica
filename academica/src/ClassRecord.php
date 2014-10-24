<?php

namespace Academica;

use App\Models\GradedItem;

/**
 * Description of ClassRecord
 *
 * @author ervinne
 */
class ClassRecord {

    public function getCategorizedGradedItems($classId) {
        $gradedItems = GradedItem::classWithHPS($classId)->get();
        return $gradedItems;
    }

}
