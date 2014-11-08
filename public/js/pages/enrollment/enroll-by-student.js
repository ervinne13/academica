
/* global _ */

(function () {

    var classTemplate;
    var studentTemplate;
    var studentSelectionTemplate;

    $(document).ready(function () {
        initializeTemplates();
        initializeView();
        initializeEvents();
    });

    function initializeTemplates() {
        classTemplate = _.template($('#assigned-classes').html());
        studentTemplate = _.template($('#student-selection-template').html());
        studentSelectionTemplate = function (student) {
            return student.first_name + " " + student.last_name;
        };
    }

    function initializeEvents() {

        $('[name=section_id]').on('change', function () {
            var classes = $(this).find('option:selected').data('classes');
            var html = "";

            for (var i in classes) {
                html += classTemplate(classes[i]);
            }

            $('#classes-tbody').html(html);

        });

        $(document).on('click', '.action-delete-class', function () {
            $(this).closest('tr').remove();
        });

        $('#action-enroll').click(enroll);

    }

    function initializeView() {
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

    function studentTemplateHandler(student) {
        if (student.loading) {
            return student.text;
        }

        return studentTemplate(student);
    }

    function enroll() {
        var studentId = $('[name=student_id]').val();
        var classes = [];

        $('.class-row').each(function () {
            classes.push($(this).data('graded-item-id'));
        });

        var url = "/enrollment/enroll-by-student";
        var data = {
            studentId: studentId,
            classes: classes
        };

        $.post(url, data, function (response) {
            console.log(response);
            swal("Success", "Successfully enrolled student", "success");
        });

    }

})();
