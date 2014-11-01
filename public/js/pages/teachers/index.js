
/* global datatable_utilities */

(function () {

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {
        $('#teachers-table').DataTable({
            aaSorting: [[4, 'asc']],
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/teachers/datatable"
            },            
            columns: [
                {data: 'id'},
                {data: 'user.email', name: 'user.email'},
                {data: 'first_name'},
                {data: 'middle_name'},
                {data: 'last_name'},
                {data: 'birthdate'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
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
