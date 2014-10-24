
/* global utilities */

(function () {

    $(document).ready(function () {

        initializeEvents();

    });

    function initializeEvents() {
        $('[name=teacher_id]').change(function () {
            loadAndSetTeacherClasses();
        });

        // TODO: test 
        $('#action-generate-class-record').click(function () {

            var period = $('#class-record-generation-period').val();
            var classId = $('#class-record-generation-class-id').val();

            generateClassRecord(period, classId);

        });

    }

    function loadAndSetTeacherClasses() {
        var teacherId = $('[name=teacher_id]').val();
        var url = baseURL + "/api/teacher/" + teacherId + "/classes";
        $.get(url, function (classes) {
            utilities.setBoxLoading($('#generate-template-container-box'), false);
//            classes = JSON.parse(classes);
            var html = "";

            for (var i in classes) {
                html += '<option value="' + classes[i].id + '">' + classes[i].name + '</option>';
            }

            $('#class-record-generation-period').html(html);

        });

        utilities.setBoxLoading($('#generate-template-container-box'), true);

    }

    function generateClassRecord(period, classId) {
        window.open(baseURL + "/period/" + period + "/class/" + classId + "/class-record/generate");
    }

})();