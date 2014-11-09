
/* global datatable_utilities */

(function () {

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {
        $('#students-table').DataTable({
            aaSorting: [[1, 'asc']],
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/students/datatable"
            },
            columns: [
                {data: 'id'},
                {data: 'last_name'},
                {data: 'first_name'},
                {data: 'section_name', name: 'sections.name'},
                {data: 'lrn'},
                {data: 'student_number'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {

                        var editAction = datatable_utilities.getDefaultEditAction(id);
                        var viewAction = datatable_utilities.getDefaultViewAction(id);
                        var view = datatable_utilities.getInlineActionsView([viewAction, editAction]);

                        return view;
                    }
                }
            ]
        });
    }

})();
