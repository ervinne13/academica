
/* global datatable_utilities */

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
                url: "/grading-years/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'is_open'},
                {data: 'name'}
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
                },
                {
                    targets: 1,
                    render: function (isOpen, type, rowData, meta) {
                        return isOpen == 1 ? "Open" : "Closed";
                    }
                }
            ]
        });
    }

})();
