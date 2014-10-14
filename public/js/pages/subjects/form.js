
/* global form_utilities, sectionId */

(function () {
    $(document).ready(function () {
        form_utilities.moduleUrl = "/sections";
        form_utilities.updateObjectId = sectionId;
        form_utilities.validate = true;        
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    });
})();
