
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
                url: "/teacher/" + teacherId + "/classes/datatable"
            },
            order: [5, "desc"],
            columns: [
                {data: 'id'},
                {data: 'id'},
                {data: 'name'},
                {data: 'grading_year.year', name: 'grading_years.year'},
                {data: 'level.name'},
                {data: 'level_id'},
                {data: 'subject.name'}
            ],
            columnDefs: [
                {searchable: false, targets: [0, 5]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {

                        var editAction = datatable_utilities.getDefaultEditAction(id);
                        var view = datatable_utilities.getInlineActionsView([editAction]);

                        return view;
                    }
                }
            ]
        });
    }

})();
