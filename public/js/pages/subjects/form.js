
/* global form_utilities, id */

(function () {
    $(document).ready(function () {
        form_utilities.moduleUrl = "/subjects";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
        
    });
})();
