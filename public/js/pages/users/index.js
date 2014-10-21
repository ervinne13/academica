
/* global datatable_utilities, baseURL */

(function () {

    var datatable;

    $(document).ready(function () {
        initializeTable();
        initializeEvents();
    });

    function initializeTable() {
        datatable = $('#datatable').DataTable({
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
                {data: 'is_active'},
                {data: 'email'},
                {data: 'name'},
                {data: 'role_name'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {

                        var actions = [];

                        if (rowData.role_name == "VIEWER") {
                            actions.push(datatable_utilities.getDefaultEditAction(id));
                        }

                        if (rowData.is_active == 1) {
                            actions.push(getDeactivateAction(id));
                        } else {
                            actions.push(getActivateAction(id));
                        }

                        return datatable_utilities.getInlineActionsView(actions);

                    }
                },
                {
                    targets: 1,
                    render: function (isActive, type, rowData, meta) {
                        return isActive == 1 ? "Active" : "Inactive";
                    }
                },
                {
                    targets: 4,
                    render: function (roleName, type, rowData, meta) {
                        switch (roleName) {
                            case "VIEWER" :
                                return "Viewer";
                            case "TEACHER" :
                                return "Teacher";
                            case "ADMIN" :
                                return "Administrator";
                        }
                    }
                }
            ]
        });
    }

    function getDeactivateAction(id) {
        return {
            id: id,
            href: 'javascript:void(0)',
            name: "deactivate",
            displayName: "Deactivate",
            icon: "fa-times"
        };
    }

    function getActivateAction(id) {
        return {
            id: id,
            href: 'javascript:void(0)',
            name: "activate",
            displayName: "Activate",
            icon: "fa-check"
        };
    }

    function initializeEvents() {
        $(document).on('click', '.action-deactivate', function () {
            var id = $(this).data('id');            
            changeActiveStatus(id, false);
        });

        $(document).on('click', '.action-activate', function () {
            var id = $(this).data('id');
            changeActiveStatus(id, true);
        });

    }

    function changeActiveStatus(id, isActive) {

        var url = baseURL + "/users/" + id + "/" + (isActive ? "activate" : "deactivate");
        $.get(url, function (response) {
            swal("Success", "User is now " + (isActive ? "active" : "inactive"), 'success');
            datatable.ajax.reload();
        });

    }

})();
