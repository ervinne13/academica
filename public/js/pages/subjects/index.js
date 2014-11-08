
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
            order: [3, "desc"],
            columns: [
                {data: 'id'},
                {data: 'is_active'},
                {data: 'level_subjects'},
                {data: 'name'},
                {data: 'short_name'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0, 2]},
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
                    render: function (levelSubjects, type, rowData, meta) {
                        console.log(levelSubjects);

                        var displayText;

                        if (levelSubjects.length > 0) {
                            displayText = "Grades ";
                            displayText += levelSubjects[0].level_id;
                            displayText += " to ";
                            displayText += levelSubjects[levelSubjects.length - 1].level_id;
                        } else {
                            displayText = "None";
                        }

                        return displayText;

                    }
                }
            ]
        });
    }

})();
