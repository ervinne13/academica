
/* global form_utilities, teacherId, baseURL, image_utils */

(function () {

    var passwordFieldsTemplate;

    $(document).ready(function () {

        //  initialize templates
        passwordFieldsTemplate = _.template($('#password-fields-template').html());

        initializeUI();
        initializeFormUtilities();
        initializeImageUtilities();
        initializeEvents();

        //  show password fields for creation
        if (mode == "ADD") {
            showPasswordFields(true);
        }

    });

    function initializeUI() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        });
    }

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/teachers";
        form_utilities.updateObjectId = teacherId;
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

    function initializeImageUtilities() {
        image_utils.initialize($('#input-teacher-image'), $('[name=image_url]'), null);
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
