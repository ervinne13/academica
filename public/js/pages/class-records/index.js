
/* global datatable_utilities, teacherId */

(function () {

    $(document).ready(function () {
        initializeTable();

        //  hide sidebar
        $('.sidebar-toggle').click();

    });

    function initializeTable() {

        var url = "/classes/datatable";

        if (teacherId) {
            url = "/teacher/" + teacherId + "/classes/datatable";
        }

        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: url
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'id'},
                {data: 'name'},
                {data: 'grading_year.year'},
                {data: 'level.name'},
                {data: 'subject.name'},
                {data: 'teacher.first_name'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [3]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {

                        var viewAction = getClassRecordViewAction(id);
                        var view = datatable_utilities.getInlineActionsView([viewAction]);

                        return view;
                    }
                },
                {
                    targets: 6,
                    render: function (id, type, rowData, meta) {
                        return rowData.teacher.first_name + " " + rowData.teacher.last_name;
                    }
                }
            ]
        });
    }

    function getClassRecordViewAction(id) {
        return {
            id: id,
            href: baseURL + "/period/1/class/" + id + "/class-record",
            name: "view",
            displayName: "View",
            icon: "fa-search"
        };
    }

})();
