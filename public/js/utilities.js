
var utilities = {};

utilities.loadingStateHtml = '<div class="loading-overlay overlay"><i class="fa fa-refresh fa-spin"></i></div>';

utilities.setBoxLoading = function ($element, show) {

    if (show) {
        $element.append(utilities.loadingStateHtml);
    } else {

        $element.find('.loading-overlay').remove();
    }

};

utilities.reloadWithWaitFunction = function () {
    return function () {
        setTimeout(function () {
            window.location.reload();
        }, globals.reloadRedirectWaitTime);
    }
};

utilities.redirectWithWaitFunction = function (redirectTo) {
    return function () {
        setTimeout(function () {
            window.location.href = redirectTo;
        }, globals.reloadRedirectWaitTime);
    };
};

utilities.trimHttp = function (url) {
    return url.substring(7, url.length);
};

utilities.trimPort = function (url) {
    if (url.indexOf(":") > 0) {
        var splittedUrl = url.split(':');
        console.log(splittedUrl);
        return splittedUrl[0];
    } else {
        return url;
    }

};
