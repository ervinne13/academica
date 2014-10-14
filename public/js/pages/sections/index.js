
/* global datatable_utilities */

(function () {

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {
        $('#sections-table').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/sections/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'section_id'},
                {data: 'level_name', name: 'levels.name'},
                {data: 'section_name', name: 'sections.name'}
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
