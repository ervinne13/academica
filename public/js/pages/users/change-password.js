
/* global form_utilities, id, _, mode */

(function () {

    var passwordFieldsTemplate;

    $(document).ready(function () {
        initializeEvents();
    });

    function initializeFormUtils() {
        form_utilities.moduleUrl = "/users";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
        form_utilities.postValidate = function () {


        };
    }

    function initializeEvents() {

        $('#action-change-password').click(function () {
            if (validate()) {
                updatePassword();
            }
        });
    }

    function validate() {
        var password1 = $('[name=new_password]').val();
        var password2 = $('[name=new_password_repeat]').val();

        if (password1 != password2) {

            form_utilities.setFieldError('password', 'Passwords do not match');
            form_utilities.setFieldError('password_repeat', 'Passwords do not match');

            swal("Error", "Passwords must match", "error");
            return false;
        }

        return true;
    }

    function updatePassword() {

        var url = "/users/" + id + "/update-password";
        var data = {
            new_password: $('[name=new_password]').val()
        };

        $.post(url, data, function (response) {
            console.log(response);
            swal("Success", "Password Updated", "success");
        });
    }

})();
