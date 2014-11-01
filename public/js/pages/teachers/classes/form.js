
/* global form_utilities, teacherId, baseURL, image_utils, classId, utilities */

(function () {
    var $gradedItemId;
    var gradedItemRowTemplate;

    $(document).ready(function () {

        //  initialize templates
        gradedItemRowTemplate = _.template($('#assigned-graded-items-row-template').html());

        initializeFormUtilities();
        initializeUI();
        initializeEvents();

        loadGradedItemOptions($('[name=subject_id]').val());
        loadAssignedGradedItems(classId);
    });

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/teacher/" + teacherId + "/classes";
        form_utilities.updateObjectId = classId;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));

        form_utilities.process = function (type, data, callback) {

            var url, method;
            if (type == "action-create-new" || type == "action-create-close") {
                url = form_utilities.moduleUrl;
                method = 'POST';
            } else if (type == "action-update-close") {
                url = form_utilities.moduleUrl + "/" + form_utilities.updateObjectId;
                method = 'PUT';
            }

            data.gradedItems = getGradedItemsData();

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function (response) {
                    console.log(response);
                    callback(true, response);
                },
                error: function (response) {
                    callback(false, response.responseText);
                }
            });

        };

    }

    function initializeUI() {
        $gradedItemId = $('[name=graded_item_id]').select2({
            data: []
        });

        $('body').on('focus', ".datepicker_recurring_start", function () {
            $(this).datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            });
        });
    }

    function initializeEvents() {
        $('[name=subject_id]').change(function () {
            var subjectId = $(this).val();
            loadGradedItemOptions(subjectId);
        });

        $('#action-add-graded-item').click(addGradedItem);

        $('#assigned-graded-items-tbody').on('click', '.action-delete-graded-item', function () {
            var gradedItemId = $(this).data('id');
            deleteGradedItem(gradedItemId);
        });

        $('#action-clear-graded-items').click(clearGradedItems);

    }

    function validateGradedItemExists(newGradedItemId) {

        var match = false;

        $('.graded-item-row').each(function () {
            var gradedItemId = $(this).data('graded-item-id');

            if (gradedItemId == newGradedItemId) {
                match = true;
            }
        });

        return !match;
    }

    function loadAssignedGradedItems(subjectId) {
        var url = "/api/class/" + subjectId + "/graded-items";
        $.get(url, function (gradedItems) {
            utilities.setBoxLoading($('#graded-items-container'), false);

            console.log(gradedItems);

            for (var i in gradedItems) {
                var rowHtml = gradedItemRowTemplate({
                    graded_item_id: gradedItems[i].graded_item_id,
                    is_active: gradedItems[i].is_active,
                    name: gradedItems[i].graded_item.name,
                    datetaken: gradedItems[i].datetaken,
                    highest_possible_score: gradedItems[i].highest_possible_score
                });

                $('#assigned-graded-items-tbody').append(rowHtml);
            }

        });
    }

    function loadGradedItemOptions(subjectId) {
        var url = "/api/subjects/" + subjectId + "/graded-items";
        $.get(url, function (gradedItems) {
            utilities.setBoxLoading($('#graded-items-container'), false);

            var options = [];
            for (var i in gradedItems) {
                options.push({
                    id: gradedItems[i].id,
                    text: gradedItems[i].name
                });
            }

            $gradedItemId.html('');
            $gradedItemId.select2({
                data: options
            });

        });

        utilities.setBoxLoading($('#graded-items-container'), true);
    }

    function addGradedItem() {
        var gradedItemId = $gradedItemId.val();
        var gradedItemName = $gradedItemId.select2('data')[0].text;

        if (validateGradedItemExists(gradedItemId)) {
            var rowHtml = gradedItemRowTemplate({
                graded_item_id: gradedItemId,
                name: gradedItemName,
                is_active: 0,
                datetaken: "",
                highest_possible_score: 0
            });

            $('#assigned-graded-items-tbody').append(rowHtml);
        } else {
            swal("Error", "Graded Item Already Added", "error");
        }

    }

    function getGradedItemsData() {
        var data = [];

        $('.graded-item-row').each(function () {
            data.push({
                class_id: classId,
                is_active: $(this).find('.is-active-field').is(':checked') ? 1 : 0,
                datetaken: $(this).find('.datetaken-field').val(),
                graded_item_id: $(this).data('graded-item-id'),
                highest_possible_score: $(this).find('.hps-field').val()
            });
        });

        console.log(data);

        return data;
    }

    function deleteGradedItem(itemId) {
        $('.graded-item-row[data-graded-item-id=' + itemId + ']').remove();
    }

    function clearGradedItems() {
        swal({
            title: "Are you sure?",
            text: "You will have to encode graded items for this class again",
            type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, clear!",
            cancelButtonText: "Cancel"
        }).then(function () {
            $('.graded-item-row').remove();
        });
    }

})();
