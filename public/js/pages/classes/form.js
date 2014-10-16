
/* global form_utilities, teacherId, baseURL, image_utils, classId */

(function () {
    $(document).ready(function () {
        initializeFormUtilities();
    });

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/classes";
        form_utilities.updateObjectId = classId;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }


})();
