'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the webApp
 */
angular.module('webApp')
  .controller('MainCtrl',[ '$scope', '$window' , function ($scope , $window) {
    $scope.loginBtnClick = function(){

    	$window.location.href = '#/home';
    }
  }]);

