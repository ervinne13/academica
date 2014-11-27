
/* global form_utilities, sectionId, _, utilities */

(function () {

    var classTemplate;

    $(document).ready(function () {

        //   initialize templates
        classTemplate = _.template($('#assigned-classes').html());

        initializeFormUtilities();
        initializeEvents();

        loadClasses(sectionId);

    });

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/sections";
        form_utilities.updateObjectId = sectionId;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

    function initializeEvents() {
        $('#action-add-class').click(addClass);

        $('#action-clear-graded-items').click(function () {
            swal({
                title: "Are you sure?",
                text: "This will remove all classes associated with this section!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, clear it!",
                closeOnConfirm: false
            }).then(function () {
                clearClasses();
            });
        });

        $(document).on('click', '.action-delete-class', deleteClass);

    }

    function loadClasses(sectionId) {
        var url = "/api/sections/" + sectionId + "/class";
        $.get(url, function (classes) {
            utilities.setBoxLoading($('#classes-container'), false);

            var html = "";

            for (var i in classes) {
                html += classTemplate(classes[i]);
            }

            $('#classes-tbody').html(html);
        });

        utilities.setBoxLoading($('#classes-container'), true);
    }

    function addClass() {

        var data = {
            section_id: sectionId,
            class_id: $('#class-id').val()
        };

        var url = "/api/sections/" + sectionId + "/class/create";

        $.post(url, data, function () {
            utilities.setBoxLoading($('#classes-container'), false);
            loadClasses(sectionId);
        });

        utilities.setBoxLoading($('#classes-container'), true);

    }

    function deleteClass() {
        var classId = $(this).data('id');
        var url = "/api/sections/" + sectionId + "/class/" + classId;

        $.ajax({
            url: url,
            type: 'DELETE',
            success: function () {
                utilities.setBoxLoading($('#classes-container'), false);
                loadClasses(sectionId);
            }
        });

        utilities.setBoxLoading($('#classes-container'), true);

    }

    function clearClasses() {
        var url = "/api/sections/" + sectionId + "/class";

        $.ajax({
            url: url,
            type: 'DELETE',
            success: function () {
                utilities.setBoxLoading($('#classes-container'), false);
                loadClasses(sectionId);

                swal("Cleared!", "Classes has been cleared", "success");
            }
        });

        utilities.setBoxLoading($('#classes-container'), true);
    }

})();
