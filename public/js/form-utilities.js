var form_utilities = {};

form_utilities.formToJSON = function ($form) {

    var json = {};

    $($form.selector + ' :input').each(function () {
        var name = $(this).attr('name');
        var value = $(this).val();

        if (name && value) {
            json[name] = value;
        }
    });

    return json;
};