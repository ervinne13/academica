
(function () {

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {
        $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/products/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'model'},
                {data: 'name'},
                {data: 'category.name'},
                {data: 'stock'},
                {data: 'price'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (columnData, type, rowData, meta) {

                        var editAction = datatable_utilities.getDefaultEditAction(columnData);
                        var view = datatable_utilities.getInlineActionsView([editAction]);

                        return view;
                    }
                }
            ]
        });
    }

})();
