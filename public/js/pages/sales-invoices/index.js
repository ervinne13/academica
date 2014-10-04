
(function () {

    var noHttpBaseURL = utilities.trimPort(utilities.trimHttp(baseURL));
    var WSConnection = null;
    var $siTable;

    $(document).ready(function () {
        initializeTable();
        initializeWS();
    });

    function initializeWS() {

        console.log('Connecting to ws://' + noHttpBaseURL + ':' + globals.socketPort);

        WSConnection = new WebSocket('ws://' + noHttpBaseURL + ':' + globals.socketPort);
        WSConnection.onopen = function (e) {
            //  for checking
            console.log("Connection established!");
            console.log(e);
        };

        WSConnection.onmessage = function (e) {
            if (e.data && e.data == "NOTIFICATION_NEW_SALES_ORDER") {
                $siTable.ajax.reload();
            }
        };

    }

    function initializeTable() {
        $siTable = $('#si-table').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/si/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'id'},
                {data: 'customer_id'},
                {data: 'customer_name'},
                {data: 'customer_email'},
                {data: 'total_item_qty'},
                {data: 'total_amount'},
                {data: 'status'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {
                        var viewAction = datatable_utilities.getDefaultViewAction(id);
                        var editAction = datatable_utilities.getDefaultEditAction(id);
                        var view = datatable_utilities.getInlineActionsView([viewAction, editAction]);

                        return view;
                    }
                },
                {
                    targets: 1,
                    render: function (id, type, rowData, meta) {
                        return "SI-" + pad(id, 8);
                    }
                },
                {
                    targets: 2,
                    render: function (customerId, type, rowData, meta) {
                        return customerId ? "Premium" : "Guest";
                    }
                }
            ]
        });
    }

    function pad(n, width, z) {
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }

})();
