
/* global teacherId, utilities */

(function () {

    var studentGradeTemplate;
    var currentlyFilteredGradedItems;

    $(document).ready(function () {

        //  initialize template
        studentGradeTemplate = _.template($('#student-grades-template').html());

        initializeEvents();

        $('#levels').select2();
        $('#classes').select2();
        $('#graded-items').select2();
        $('#grading-periods').select2();

    });

    function initializeEvents() {

        $('#action-save-grades').click(save);
        $('#action-cancel').click(function () {
            location.reload();
        });

        $('#levels').change(function () {
            loadClasses();
        });

        $('.graded-item-filter-select').change(function () {
            loadGradedItem();
        });

        $('#graded-items').on('change', function () {
            var classId = $('#classes').val();
            var gradedItemId = $('#graded-items').val();

            if (classId && gradedItemId) {

                for (var i in currentlyFilteredGradedItems) {
                    if (currentlyFilteredGradedItems[i].id == gradedItemId) {
                        displayGradedItemInfo(currentlyFilteredGradedItems[i]);
                        break;
                    }
                }

                loadStudents(classId, gradedItemId);
            }

        });

    }

    function displayGradedItemInfo(gradedItem) {

        $('#gi-info-name').html(gradedItem.name);
        $('#gi-info-short-name').html(gradedItem.short_name);
        $('#gi-info-type').html(gradedItem.graded_item_type.name);
        $('#gi-info-hps').html(gradedItem.highest_possible_score);

        $('#student-grades-grade-col-header').html("Grade (HPS = " + gradedItem.highest_possible_score + ")");
        $('#student-grades-grade-col-header').attr("data-hps", gradedItem.highest_possible_score);

    }

    function loadClasses() {
        var levelId = $('#levels').val();

        if (levelId) {

            var url = "/api/teacher/" + teacherId + "/" + levelId;

            $.get(url, function (gradedItems) {
                currentlyFilteredGradedItems = gradedItems;
                console.log(currentlyFilteredGradedItems);
                displayGradedItemsOnSelect();
            });

        }

    }

    function loadStudents(classId, gradedItemId) {
        var url = "/classes/" + classId + "/students/" + gradedItemId + "/grades";

        $.get(url, function (grades) {
            utilities.setBoxLoading($('#grading-container'), false);
            console.log(grades);

            var html = "";

            for (var i in grades) {
                html += studentGradeTemplate(grades[i]);
            }

            $('#student-grades-tbody').html(html);

        });

        utilities.setBoxLoading($('#grading-container'), true);

    }

    function loadGradedItem() {
        var classId = $('#classes').val();
        var gradingPeriodId = $('#grading-periods').val();

        if (classId && gradingPeriodId) {

            var url = "/api/graded-items?classId=" + classId;
            url += "&periodId=" + gradingPeriodId;

            $.get(url, function (gradedItems) {
                currentlyFilteredGradedItems = gradedItems;
                console.log(currentlyFilteredGradedItems);
                displayGradedItemsOnSelect();
            });

        }

    }

    function displayGradedItemsOnSelect() {
        $("#graded-items").html('');
        $("#graded-items").select2("destroy");
        $('#graded-items').select2({
            data: getIdAndLabelFromGradedItems(currentlyFilteredGradedItems)
        });

        $('#graded-items').change();
    }

    function getIdAndLabelFromGradedItems(gradedItems) {
        var options = [];

        for (var i in gradedItems) {
            options.push({
                id: gradedItems[i].id,
                text: gradedItems[i].name
            });
        }

        return options;
    }

    function save() {

        var classId = $('#classes').val();
        var gradedItemId = $('#graded-items').val();

//        var url = "/classes/" + classId + "/students/" + gradedItemId + "/grades";
        var url = "/class-grading";
        var data = {
            class_id: classId,
            graded_item_id: gradedItemId,
            records: []
        };

        var hps = $('#student-grades-grade-col-header').data('hps');
        var valid = true;

        $('.student-row').each(function () {
            var fieldName = $(this).find('.score-field').attr('name');
            var record = {
                student_id: $(this).data('student-id'),
                score: $(this).find('.score-field').val()
            };

            form_utilities.clearError(fieldName);

            if (record.score > hps) {
                form_utilities.setFieldError(fieldName, "The score should not exceed the highest possible score");
                valid = false;
            }

            data.records.push(record);
        });

        if (valid) {
            data.records = JSON.stringify(data.records);

            $.post(url, data, function (response) {
                utilities.setBoxLoading($('#students-container'), false);
                console.log(response);
                swal("Success", "Grades Saved!", "success");
            });

            utilities.setBoxLoading($('#students-container'), true);
        } else {
            swal("Error", "Please correct your input errors before saving, thank you", "warning");
        }

    }

})();
