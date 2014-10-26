
var image_utils = {};

image_utils.initialize = function ($selector, $imageUrlInput, baseUrl) {
    $selector.change(function () {
        image_utils.previewFileImage(this, $('#image-preview'));
        image_utils.uploadFile(this, $imageUrlInput);
    });

    image_utils.baseUrl = baseUrl;
};

image_utils.previewFileImage = function ($input, $img) {
    if ($input.files && $input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $img.attr('src', e.target.result);
        };

        reader.readAsDataURL($input.files[0]);
    }
};

image_utils.uploadFile = function ($input, $imageUrlInput) {
    if ($input.files && $input.files[0]) {
        var formData = new FormData();
        formData.append('file', $input.files[0]);

        $.ajax({
            url: '/files/upload',
            type: 'POST',
            processData: false, // important
            contentType: false, // important                
            data: formData,
            success: function (response) {
                console.log(response);
                if (utilities) {
                    utilities.setBoxLoading($('#image-preview-container'), false);
                }
                if ($imageUrlInput) {
                    try {
                        var uploadNames = JSON.parse(response);
                    } catch (e) {
                        console.warn(e);
                        var uploadNames = [response];
                    }
                    if (uploadNames.length > 0) {

                        var filePath = image_utils.baseUrl ? image_utils.baseUrl + "/uploads/" + uploadNames[0] : "/uploads/" + uploadNames[0];

                        $imageUrlInput.val(filePath);
                    }
                }
            }
        });

        if (utilities) {
            utilities.setBoxLoading($('#image-preview-container'), true);
        }
    }
};