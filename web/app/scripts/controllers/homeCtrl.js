'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the webApp
 */
angular.module('webApp')
  .controller('HomeCtrl',['$scope', 'apiService', 'utilsService',  function ($scope, apiService, utilsService) {
  	$scope.lengthFlag = false;
  	$scope.searchText = "";
  	$scope.getSearchList = function(){
  		if($("#search").val() == ""){
  			getResultsPage(1);
  		}else{
  			getResultsSearch(1);
  		}
  	}
  	function getResultsSearch(pageNumber) {
  		$scope.lengthFlag = false;
        // this is just an example, in reality this stuff should be in a service
        apiService.getSearchList($scope.phonesPerPage, ((pageNumber-1)*($scope.phonesPerPage-1))).then(function(resp){
        	$scope.lengthFlag = true;
  			$scope.phoneList = resp[0].phoneObjs;
  			$scope.totalItems = resp[0].count;
  		},function(resp){
  			utilsService.showMessage(resp, false);
  		});
    }
  	$scope.logoutFlag = true;
  	$scope.phoneList = [];
    $scope.totalItems = 0;
    $scope.phonesPerPage = 5; // this should match however many results your API puts on one page
    getResultsPage(1);
    $scope.cancelEditing = function($event){
    	$scope.editFlag = false;
    	$("#name").val("");
    	$("#phone_number").val("");
    	$("#additional_notes").val("");
    	$event.preventDefault();

    }
    $scope.pagination = {
        current: 1
    };
    $scope.editFlag = false;
    $scope.tempPhoneObj = {};
    $scope.editPhoneNumber = function(phoneObj){
    	$scope.editFlag = true;
    	$("#name").val(utilsService.escapeHtml(phoneObj.name));
    	$("#phone_number").val(utilsService.escapeHtml(phoneObj.phone_number));
    	$("#additional_notes").val(utilsService.escapeHtml(phoneObj.additional_notes));
    	$scope.tempPhoneObj = phoneObj;
    }
    //$(".paginator").off("click");
    $scope.pageChanged = function(newPage,$event) {
    	if($("#search").val() == ""){
    		getResultsPage(newPage);	
    	}else{
    		getResultsSearch(newPage);
    	}
    	
   };

    function getResultsPage(pageNumber) {
    	$scope.lengthFlag = false;
        // this is just an example, in reality this stuff should be in a service
        apiService.getList($scope.phonesPerPage, ((pageNumber-1)*($scope.phonesPerPage-1))).then(function(resp){
        	$scope.lengthFlag = true
  			$scope.phoneList = resp[0].phoneObjs;
  			$scope.totalItems = resp[0].count;
  		},function(resp){
  			utilsService.showMessage(resp, false);
  		});
    }
  	/*$(document).ready(function(){
  		console.log("asadsfas");
  		apiService.getList().then(function(resp){

  			$scope.phoneList = resp[0].phoneObjs;
  			$scope.totalItems = $scope.phoneList.length;
  			console.log($scope.phoneList);
  		},function(resp){

  		});

  	});*/
	$(".parent-div").on("mouseover", ".additional-icon", function(){
		$(this).popover("show");
	});
  	$scope.deletePhoneNumber = function(phoneObj){
  		apiService.deletePhoneNumber(phoneObj).then(function(resp){
	             	utilsService.showMessage(resp, true);
	             	getResultsPage($scope.pagination.current);	
	             },function(resp){
	             	utilsService.showMessage(resp, false);
	             }); 
  	}
  	$(function () {
	  	$('.action-icons').popover();
  	});
    $scope.eventformvalidate = {
	    rules: {
	        name: {
	            required: true
	        },
	        phone_number: {
	            required: true
	        }
	    },
	    messages: {
	    },
	    submitHandler: function (form) {

	    	 
	    	 	
	    	 if($scope.editFlag){
	    	 	$scope.tempPhoneObj.name= utilsService.escapeHtml($("#name").val());
	    	 	$scope.tempPhoneObj.phone_number = utilsService.escapeHtml($("#phone_number").val());
	    	 	$scope.tempPhoneObj.additional_notes = ($("#additional_notes").val() == "") ? "" : utilsService.escapeHtml($("#additional_notes").val()) ;
	    	 
	    	 	apiService.editPhoneNumber($scope.tempPhoneObj).then(function(resp){
	             	utilsService.showMessage(resp, true);
	             	$("#name").val("");
	             	$("#phone_number").val("");
	             	$("#additional_notes").val("");
	             	$scope.editFlag = false;	
	             },function(resp){
	             	utilsService.showMessage(resp, false);
	             }); 
	    	 }else{
	    	 	var phoneData = {
	    	 			name: $("#name").val(),
	    	 			phone_number: $("#phone_number").val(),
	    	 			additional_notes: ($("#additional_notes").val() == "") ? "" : $("#additional_notes").val() 
	    	 	}
	    	 	apiService.addNewPhoneNumber(phoneData).then(function(resp){
	             	utilsService.showMessage(resp, true);
	             	$("#name").val("");
	             	$("#phone_number").val("");
	             	$("#additional_notes").val("");
	             },function(resp){
	             	utilsService.showMessage(resp, false);
	             }); 
	    	 }
                    
         },
	    validateOnInit: false
	};
  }]);
