
/* global datatable_utilities */

(function () {

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {
        $('#subjects-table').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/subjects/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'is_active'},
                {data: 'is_default'},
                {data: 'name'},
                {data: 'short_name'}
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
                    render: function (isActive, type, rowData, meta) {
                        return isActive == 1 ? "Active" : "Inactive";
                    }
                },
                {
                    targets: 2,
                    render: function (isDefault, type, rowData, meta) {
                        return isDefault == 1 ? "Yes" : "No";
                    }
                }
            ]
        });
    }

})();
