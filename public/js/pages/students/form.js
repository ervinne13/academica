
/* global form_utilities, image_utils, id */

(function () {

    $(document).ready(function () {
        initializeUI();
        initializeFormUtilities();
        initializeImageUtilities();
    });

    function initializeUI() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        });
    }

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