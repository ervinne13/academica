
/* global form_utilities, sectionId */

(function () {
    $(document).ready(function () {
        form_utilities.moduleUrl = "/graded-items";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    });
})();
