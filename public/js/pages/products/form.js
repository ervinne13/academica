(function () {

    var moduleUrl = "/products";
    var fileUploadPending = false;

    $(document).ready(function () {
        initializeEvents();
    });

    function initializeEvents() {
        $("#input-product-image").change(function () {
            previewFileImage(this, $('#product-image'));
            uploadFile(this);
        });

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

    function previewFileImage(input, $img) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $img.attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function uploadFile(input) {
        if (input.files && input.files[0]) {
            var formData = new FormData();
            formData.append('file', input.files[0]);

            $.ajax({
                url: '/file/upload',
                type: 'POST',
                processData: false, // important
                contentType: false, // important                
                data: formData,
                success: function (response) {
                    console.log(response);
                    $('[name=url]').val("/uploads/" + response);
                    fileUploadPending = false;
                }
            });

            fileUploadPending = true;

        }
    }

    function save(callback) {

        if (fileUploadPending) {
            swal({
                title: "Upload Pending",
                text: "Upload is still ongoing! Please wait",
                type: "warning"
            });
            return;
        }

        var url;
        var method;
        var data = form_utilities.formToJSON($('#form-product'));

        if (productId != 0) {
            url = "/products/" + productId;
            method = 'PUT';
        } else {
            url = "/products";
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