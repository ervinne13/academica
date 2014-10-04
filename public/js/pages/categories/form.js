
/* global globals, utilities, form_utilities, categoryId */

(function () {

    var moduleUrl = "/categories";

    $(document).ready(function () {
        initializeEvents();
    });

    function initializeEvents() {

        $('#action-create-new').click(function () {
            save(utilities.reloadWithWaitFunction());
        });

        $('#action-create-close').click(function () {
            save(utilities.redirectWithWaitFunction(moduleUrl));
        });

        $('#action-update-close').click(function () {
            save(utilities.redirectWithWaitFunction(moduleUrl));
        });

    }

    function save(callback) {

        var url;
        var method;
        var data = form_utilities.formToJSON($('#form-category'));

        if (categoryId != 0) {
            url = "/categories/" + categoryId;
            method = 'PUT';
        } else {
            url = "/categories";
            method = 'POST';
        }

        $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                swal("Success!", "Category Saved!", "success");
                callback();
            }
        });
    }

})();
