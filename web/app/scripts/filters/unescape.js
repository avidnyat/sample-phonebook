// this filter is used in all views to unescape special characters in html
(function () {
    angular.module('webApp.filters', []).filter('unescapeFilter',[ 'utilsService', function (utilsService) {
        return function (input) {
            return utilsService.unescapeHtml(input)
        };
    }]);
})();