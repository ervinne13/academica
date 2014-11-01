
/* global datatable_utilities, gradedItemTypeId */

(function () {

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {

        var url;

        if (gradedItemTypeId == 0) {
            url = "/graded-items/datatable";
        } else {
            url = "/graded-items/type/" + gradedItemTypeId + "/datatable";
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
                {data: 'id', name: 'graded_items.id'},
                {data: 'name', name: 'graded_items.name'},
                {data: 'short_name', name: 'graded_items.short_name'},
                {data: 'subject_short_name', name: 'subjects.short_name'},
                {data: 'type_name', name: 'graded_item_types.name'},
                {data: 'grading_period', name: 'grading_periods.name'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {

                        var editAction = getEditAction(id);
                        var view = datatable_utilities.getInlineActionsView([editAction]);

                        return view;
                    }
                }
            ]
        });
    }

    function getEditAction(id) {
        return {
            id: id,
            href: "/graded-items/" + id + "/edit",
            name: "edit",
            displayName: "Edit",
            icon: "fa-pencil"
        };
    }

})();
