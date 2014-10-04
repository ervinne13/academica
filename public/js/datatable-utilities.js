
/* global _ */

var datatable_utilities = {};

/**
 * Requires #template-table-inline-actions
 * @param {type} actions
 * @returns {undefined}
 */
datatable_utilities.getInlineActionsView = function (actions) {

    var template = _.template($('#template-table-inline-actions').html());

    return template({actions: actions});

};

datatable_utilities.getDefaultViewAction = function (id) {
    return {
        id: id,
        href: window.location.href + "/" + id,
        name: "view",
        displayName: "View",
        icon: "fa-search"
    };
};

datatable_utilities.getDefaultEditAction = function (id) {
    return {
        id: id,
        href: window.location.href + "/" + id + "/edit",
        name: "edit",
        displayName: "Edit",
        icon: "fa-pencil"
    };
};


datatable_utilities.getDefaultDeleteAction = function (id) {
    return {
        id: id,
        href: window.location.href + "/" + id,
        name: "delete",
        displayName: "Delete",
        icon: "fa-times"
    };
};
