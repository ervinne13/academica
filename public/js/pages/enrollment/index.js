
/* global baseURL, utilities */

(function () {

    var studentListItemTemplate;
    var studentTemplate;
    var studentSelectionTemplate;

    $(document).ready(function () {
        initializeTemplates();
        initializeView();
        initializeEvents();

        loadAndDisplayEnrolledStudents();
    });

    function initializeTemplates() {
        studentListItemTemplate = _.template($('#student-list-item-template').html());
        studentTemplate = _.template($('#student-selection-template').html());
        studentSelectionTemplate = function (student) {
            return student.first_name + " " + student.last_name;
        };
    }

    function initializeView() {
        refreshSelectedClassLabel();
        $('[name=student_id]').select2({
            ajax: {
                url: "/api/students/search",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        classId: $('[name=class_id]').val(),
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: studentTemplateHandler, // omitted for brevity, see the source of this page
            templateSelection: studentSelectionTemplate // omitted for brevity, see the source of this page
        });
    }

    function initializeEvents() {
        $('[name=student_id]').change(function () {
//            alert($(this).val());
        });

        $('[name=teacher_id]').change(function () {
            loadAndSetTeacherClasses();
        });

        $('[name=class_id]').change(function () {
            refreshSelectedClassLabel();
            loadAndDisplayEnrolledStudents();
        });

        $('#action-enroll').click(enrollCurrentlySelectedStudent);
        $(document).on('click', '.action-drop-student', dropStudent);
    }

    function studentTemplateHandler(student) {
        if (student.loading) {
            return student.text;
        }

        return studentTemplate(student);
    }

    function refreshSelectedClassLabel() {
        $('#selected-class-label').text($('[name=class_id] option:selected').text());
    }

    function loadAndSetTeacherClasses() {
        var teacherId = $('[name=teacher_id]').val();
        var url = baseURL + "/api/teacher/" + teacherId + "/classes";
        $.get(url, function (classes) {
            utilities.setBoxLoading($('#students-to-enroll-box'), false);
//            classes = JSON.parse(classes);
            var html = "";

            for (var i in classes) {
                html += '<option value="' + classes[i].id + '">' + classes[i].name + '</option>';
            }

            $('[name=class_id]').html(html);

        });

        utilities.setBoxLoading($('#students-to-enroll-box'), true);

    }

    function loadAndDisplayEnrolledStudents(onFinish) {
        var classId = $('[name=class_id]').val();
        var url = baseURL + "/api/class/" + classId + "/students";
        $.get(url, function (students) {
            utilities.setBoxLoading($('#students-currently-enrolled-box'), false);

            var html = "";
            for (var i in students) {
                html += studentListItemTemplate(students[i]);
            }

            $('#enrolled-students-ul').html(html);

            if (onFinish) {
                onFinish(true);
            }
        });
        utilities.setBoxLoading($('#students-currently-enrolled-box'), true);
    }

    function enrollCurrentlySelectedStudent() {

        var data = {
            class_id: $('[name=class_id]').val(),
            student_id: $('[name=student_id]').val()
        };

        $.post('enrollment', data, function (response) {
            utilities.setBoxLoading($('#students-currently-enrolled-box'), false);
            console.log(response);
            //  reset selection
            $("#customers_select").select2("val", "");

            //  reload enrolled students
            loadAndDisplayEnrolledStudents();
        });

        utilities.setBoxLoading($('#students-currently-enrolled-box'), true);

    }

    function dropStudent() {
        var classId = $(this).data('class-id');
        var studentId = $(this).data('id');
        var studentName = $(this).data('name');

        swal({
            title: "Are you sure?",
            text: "This student will be removed / dropped from this class!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, remove student",
            closeOnConfirm: false}, function () {

        }).then(function () {
            $.ajax({
                url: '/api/class/' + classId + "/students/" + studentId,
                type: 'DELETE',
                success: function (result) {
                    loadAndDisplayEnrolledStudents();
                    swal("Removed!", studentName + " is now removed from the class.", "success");
                }
            });
        });

    }
})();