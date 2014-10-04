
/* global siId, globals */

(function () {

    var noHttpBaseURL = utilities.trimPort(utilities.trimHttp(baseURL));
    var WSConnection = null;
    var $siTable;

    $(document).ready(function () {
        //  initialize events
        $('#action-update-close').click(update);

        initializeWS();

    });

    function initializeWS() {

        WSConnection = new WebSocket('ws://' + noHttpBaseURL + ':' + globals.socketPort);
        WSConnection.onopen = function (e) {
            //  for checking
            console.log("Connection established!");
            console.log(e);
        };

        WSConnection.onmessage = function (e) {

        };

    }

    function update() {

        var data = {
            status: $('[name=status]').val(),
            remarks: $('[name=remarks]').val(),
            discount: $('[name=discount]').val()
        };
        $.ajax({
            url: "/si/" + siId,
            type: 'PUT',
            data: data,
            dataType: 'json',
            success: function (response) {
                console.log(response);

                var contact = $('[name=contact]').val();

                if (contact) {
                    var notification = {
                        type: "NOTIFICATION_SALES_ORDER_UPDATED",
                        salesOrderId: siId,
                        contact: contact,
                        status: $('[name=status]').val(),
                        remarks: $('[name=remarks]').val()
                    };
                    try {
                        WSConnection.send(JSON.stringify(notification));
                    } catch (e) {
                        console.error(e);
                    }
                    console.log(notification);
                }

                swal("Success!", "Sales Invoice Info Saved!", "success");
//
                setTimeout(function () {
                    location.href = "/si";
                }, globals.reloadRedirectWaitTime);
            }
        });
    }

})();
