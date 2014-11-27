
/* global datatable_utilities, teacherId */

(function () {

    $(document).ready(function () {
        initializeTable();
    });
    function initializeTable() {
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/classes/datatable"
            },
            order: [5, "asc"],
            columns: [
                {data: 'id'},
                {data: 'id'},
                {data: 'name'},
                {data: 'grading_year.year', name: 'gradingYear.year'},
                {data: 'level.name'},
                {data: 'level.id', name: 'level_id'},
                {data: 'subject.name'},
                {data: 'teacher.first_name'}
            ],
            columnDefs: [
                {aearchable: false, targets: [0, 5]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {

                        var editAction = datatable_utilities.getDefaultEditAction(id);
                        var view = datatable_utilities.getInlineActionsView([editAction]);
                        return view;
                    }
                },
                {
                    targets: 5,
                    visible: false
                },
                {
                    targets: 7,
                    render: function (id, type, rowData, meta) {
                        return rowData.teacher.first_name + " " + rowData.teacher.last_name;
                    }
                }
            ]
        });
    }

})();
