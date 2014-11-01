
/* global classId, gradedItemId, utilities, _ */

(function () {

    var studentGradeTemplate;

    $(document).ready(function () {

        //  initialize template
        studentGradeTemplate = _.template($('#student-grades-template').html());

        loadStudents(classId);

        //  initialize events
        $('#action-save').click(save);

    });

    function loadStudents(classId) {
        var url = "/classes/" + classId + "/students/" + gradedItemId + "/grades";

        $.get(url, function (grades) {
            utilities.setBoxLoading($('#students-container'), false);
            console.log(grades);

            var html = "";

            for (var i in grades) {
                html += studentGradeTemplate(grades[i]);
            }

            $('#students-tbody').html(html);

        });

        utilities.setBoxLoading($('#students-container'), true);

    }

    function save() {

//        var url = "/classes/" + classId + "/students/" + gradedItemId + "/grades";
        var url = "/class-grading";
        var data = {
            class_id: classId,
            graded_item_id: gradedItemId,
            records: []
        };

        $('.student-row').each(function () {
            var record = {
                student_id: $(this).data('student-id'),
                score: $(this).find('.score-field').val()
            };

            data.records.push(record);
        });

        data.records = JSON.stringify(data.records);

        $.post(url, data, function (response) {
            utilities.setBoxLoading($('#students-container'), false);
            console.log(response);
            swal("Success", "Grades Saved!", "success");
        });

        utilities.setBoxLoading($('#students-container'), true);

    }

})();
