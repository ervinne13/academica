
/* global form_utilities, image_utils, id */

(function () {

    $(document).ready(function () {
        initializeFormUtilities();
        initializeImageUtilities();
    });

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/students";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

    function initializeImageUtilities() {
        image_utils.initialize($('#input-student-image'), $('[name=image_url]'), null);
    }
})();