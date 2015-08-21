'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the webApp
 */
angular.module('webApp')
  .controller('LoginCtrl',[ '$scope', '$window', 'apiService', function ($scope , $window, apiService) {
    $scope.loginBtnClick = function(){

    	$window.location.href = '#/home';
    }
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
	    	 	username: $("#username").val(),
	    	 	password: $("#password").val()
	    	 }
             apiService.doAuthentication(userData).then(function(resp){
             	console.log(resp);
             	//UtilsService.storeCsrfToken(resp.csrf);

             	$window.location.href = '#/home';
             },function(resp){
             	console.log(resp);
             	$( ".messages" ).animate({
						left: "30px",

						}, 1500 ).delay(5000).animate({
							left: "-530px"
						},1500);
             });          
         },
	    validateOnInit: false
	};
  }]);

