/* global globals */

var form_utilities = {
    moduleUrl: "/",
    updateObjectId: 0,
    validate: null,
    postValidate: function () {},
    errorHandler: null,
    successHandler: null
};
form_utilities.formToJSON = function ($form) {

    var json = {};

    $($form.selector + ' :input').each(function () {
        var name = $(this).attr('name');
        var value = $(this).val();

        if (name && value) {
            json[name] = value;
        }
    });

    return json;
};

form_utilities.setFieldError = function (fieldName, errorMessage) {
    var errorLabelHtml = '<label id="' + fieldName + '-error" class="error" for="' + fieldName + '">' + errorMessage + '</label>';

    //  clear previous error
    $('#' + fieldName + '-error').remove();

    //  insert new error
    $('[name=' + fieldName + ']').parent().append(errorLabelHtml);
};

form_utilities.initializeDefaultProcessing = function ($form) {

    $('.action-button').click(function () {

        var valid = true;
        if (form_utilities.validate) {
            valid = $form.valid();
            form_utilities.postValidate();
        }

        if (valid) {
            var type = $(this).attr('id');
            var data = form_utilities.formToJSON($form);
            try {
                form_utilities.process(type, data, function (success, message) {
                    if (success) {

                        if (form_utilities.successHandler) {
                            form_utilities.successHandler(message);
                        } else {
                            setTimeout(function () {
                                if (type == "action-create-new") {
                                    window.location.reload();
                                } else if (type == "action-create-close" || type == "action-update-close") {
                                    window.location.href = form_utilities.moduleUrl;
                                }
                            }, globals.reloadRedirectWaitTime);

                            if (form_utilities.onSaveMessage) {
                                swal("Success!", form_utilities.onSaveMessage, "success");
                            } else {
                                swal("Success!", "Saved!", "success");
                            }
                        }
                    } else {
                        console.error(message);

                        if (form_utilities.errorHandler) {
                            form_utilities.errorHandler(message);
                        } else {
                            swal("Error!", message, "error");
                        }
                    }
                });
            } catch (e) {
                if (e.statusText) {
                    swal("Error!", e.statusText, "error");
                } else {
                    console.error(e);
                }
            }
        }

    });

};

form_utilities.process = function (type, data, callback) {

    var url, method;
    if (type == "action-create-new" || type == "action-create-close") {
        url = form_utilities.moduleUrl;
        method = 'POST';
    } else if (type == "action-update-close") {
        url = form_utilities.moduleUrl + "/" + form_utilities.updateObjectId;
        method = 'PUT';
    }

    $.ajax({
        url: url,
        type: method,
        data: data,
//        dataType: 'json',
        success: function (response) {
            console.log(response);
            callback(true, response);
        },
        error: function (response) {
            callback(false, response.responseText);
        }
    });

};
