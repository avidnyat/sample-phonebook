'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the webApp
 */
angular.module('webApp.Services')
	.service('apiService',[ 'crudService', 'configService', '$q', function (crudService, configService, $q) {
   		function doAuthentication($requestParams){		
   			var deferred = $q.defer();
   			crudService.postApi($requestParams, configService.urlObj.user_login, true).then(function(resp){
				deferred.resolve(resp);
   			},function(resp){
				deferred.reject(resp)
   			});
   			return deferred.promise;
   		}
   		function getList(limit, offset){
   			var deferred = $q.defer();
   			crudService.getApi(configService.urlObj.phone_list, limit, offset).then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){
   				deferred.reject(resp);
   			});
   			return deferred.promise;
   		}
   		function logout(){
   			var deferred = $q.defer();
   			crudService.getApi(configService.urlObj.user_logout).then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){
   				deferred.reject(resp);
   			});
   			return deferred.promise;
   		}
   		function addNewPhoneNumber(phoneData){
   			var deferred = $q.defer();
   			crudService.postApi(phoneData, configService.urlObj.phone_add, false).then(function(resp){
   				deferred.resolve(resp);	
   			},function(resp){
   				deferred.reject(resp);
   			});	
   			return deferred.promise;
   		}
   		function editPhoneNumber(phoneObj){
   			var deferred = $q.defer();
   			crudService.putApi(phoneObj,configService.urlObj.phone_edit).then(function(resp){
   				deferred.resolve(resp);	
   			},function(resp){
   				deferred.reject(resp);
   			});	
   			return deferred.promise;
   		}
   		function deletePhoneNumber(phoneObj){
   			var deferred = $q.defer();
   			crudService.deleteApi(phoneObj,configService.urlObj.phone_delete).then(function(resp){
   				deferred.resolve(resp);	
   			},function(resp){
   				deferred.reject(resp);
   			});	
   			return deferred.promise;	
   		}
   		function getSearchList(limit, offset){
   			var deferred = $q.defer();
   			crudService.getApi(configService.urlObj.phone_search, limit, offset).then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){
   				deferred.reject(resp);
   			});
   			return deferred.promise;
   		}
   		return {
   			doAuthentication: doAuthentication,
   			getList: getList,
   			addNewPhoneNumber: addNewPhoneNumber,
   			editPhoneNumber: editPhoneNumber,
   			deletePhoneNumber: deletePhoneNumber,
   			logout: logout,
   			getSearchList: getSearchList
   		}
 
   }]);
