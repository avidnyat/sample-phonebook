'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the webApp
 */
angular.module('webApp.Services')
  .service('crudService',[ 'Restangular','$q' ,'utilsService', function (Restangular, $q, utilsService) {
   		function postApi(requestParams, objectType, loginFlag){
   			var deferred = $q.defer();
   			console.log(objectType);
   			var postObj = Restangular.all(objectType);
   			var csrfObj = {};
   			if(!loginFlag){
   				csrfObj = {"csrf": utilsService.getCsrfToken()}
   			}
   			postObj.post(requestParams, csrfObj).then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){
   				deferred.reject(resp);
   			});	
   			return deferred.promise;
   		}

   		function getApi(objectType, limit, offset){
   			var searchParam = ($("#search").val() !== "") ? "&search="+$("#search").val() : "";
   			var deferred = $q.defer();
   			Restangular.all(objectType+"?limit="+limit+"&offset="+offset+"&csrf="+utilsService.getCsrfToken()+searchParam).getList().then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){
   				deferred.reject(resp);
   			});
   			return deferred.promise;
   		}
   		function putApi(phone,objectType){
   			var deferred = $q.defer();

   			Restangular.one(objectType, phone.id).customPUT(phone, "",{"csrf": utilsService.getCsrfToken()}).then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){
   				deferred.reject(resp);
   			});	
   			return deferred.promise;
   		}
   		function deleteApi(phone,objectType){
   			var deferred = $q.defer();
   			Restangular.one(objectType, phone.id).customDELETE("",{"csrf": utilsService.getCsrfToken()}).then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){
   				deferred.reject(resp);
   			});	
   			return deferred.promise;
   		}
   		return{
   			postApi: postApi,
   			getApi: getApi,
   			putApi: putApi,
   			deleteApi: deleteApi
   		}
  }]);
