
/* global form_utilities, teacherId, baseURL, image_utils */

(function () {
    $(document).ready(function () {
        initializeFormUtilities();
        initializeImageUtilities();
    });

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/teachers";
        form_utilities.updateObjectId = teacherId;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

    function initializeImageUtilities() {
        image_utils.initialize($('#input-teacher-image'), $('[name=image_url]'), null);
    }

})();
