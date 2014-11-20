
/* global form_utilities, id, _, mode */

(function () {

    var passwordFieldsTemplate;

    $(document).ready(function () {

        //  initialize templates
        passwordFieldsTemplate = _.template($('#password-fields-template').html());

        initializeFormUtils();
        initializeEvents();

        //  show password fields for creation
        if (mode == "ADD") {
            showPasswordFields(true);
        }
    });

    function initializeFormUtils() {
        form_utilities.moduleUrl = "/users";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
        form_utilities.postValidate = function () {
            var password1 = $('[name=password]').val();
            var password2 = $('[name=password_repeat]').val();

            if (password1 != password2) {

                form_utilities.setFieldError('password', 'Passwords do not match');
                form_utilities.setFieldError('password_repeat', 'Passwords do not match');

                swal("Error", "Passwords must match", "error");
                return false;
            }

            return true;
        };
    }

    function initializeEvents() {

        $('#action-show-passwords-field').click(function () {
            showPasswordFields(true);
        });

    }

    function showPasswordFields(show) {
        if (show) {
            $('#password-fields-container').html(passwordFieldsTemplate());
        } else {
            $('#password-fields-container').html('');
        }
    }

})();
