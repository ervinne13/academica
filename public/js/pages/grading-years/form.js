
/* global form_utilities, sectionId */

(function () {
    $(document).ready(function () {
        form_utilities.moduleUrl = "/grading-years";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;        
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    });
})();
