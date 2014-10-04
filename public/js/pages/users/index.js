
(function () {

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/users/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'email'},
                {data: 'name'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (columnData, type, rowData, meta) {
                        var viewAction = datatable_utilities.getDefaultViewAction(columnData);
                        var view = datatable_utilities.getInlineActionsView([viewAction]);

                        return view;
                    }
                }
            ]
        });
    }

})();
