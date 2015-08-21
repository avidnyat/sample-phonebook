'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the webApp
 */
angular.module('webApp')
  .controller('HomeCtrl',['$scope', 'apiService',  function ($scope, apiService) {
  	console.log("asdfdasfs");
  	$(document).ready(function(){
  		console.log("asadsfas");
  		apiService.getList().then(function(resp){
  			$scope.phoneList = resp[0].phoneObjs;
  			console.log($scope.phoneList);
  		},function(resp){

  		});

  	});
  	
  	$(function () {
	  	$('.action-icons').popover();
  	});
    
  }]);
