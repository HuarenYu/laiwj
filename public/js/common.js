
(function($) {

})(jQuery);
(function(window, $) {

    var API = window.API = {};
    var API_BASE_URL = '/api';

    //客栈
    var inns = API.inns = {};
    var innsUrl = API.inns.url = API_BASE_URL + '/inns/';

    inns.getAll = function() {
        return $.get(innsUrl);
    };

    inns.get = function(id) {
        return $.get(innsUrl + id);
    };

    inns.add = function(inn) {
        return $.post(innsUrl, inn);
    }


})(window, jQuery);
//# sourceMappingURL=common.js.map
