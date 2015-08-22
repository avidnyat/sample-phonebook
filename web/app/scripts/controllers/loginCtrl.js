'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the webApp
 */
angular.module('webApp')
  .controller('LoginCtrl',[ '$scope', '$window', 'apiService', 'utilsService', function ($scope , $window, apiService, utilsService) {
    $scope.loginBtnClick = function(){

    	$window.location.href = '#/home';
    }
    $scope.logoutFlag = false;
    $scope.eventformvalidate = {
	    rules: {
	        username: {
	            required: true
	        },
	        password: {
	            required: true
	        }
	    },
	    messages: {
	    },
	    submitHandler: function (form) {
	    	 var userData = {
	    	 	username: utilsService.escapeHtml($("#username").val()),
	    	 	password: utilsService.escapeHtml($("#password").val())
	    	 }
             apiService.doAuthentication(userData).then(function(resp){
             	console.log(resp[0].csrf);
             	utilsService.storeCsrfToken(resp[0].csrf);
             	$window.location.href = '#/home';
             },function(resp){
                utilsService.showMessage(resp, false); 	
             });          
         },
	    validateOnInit: false
	};
  }]);

