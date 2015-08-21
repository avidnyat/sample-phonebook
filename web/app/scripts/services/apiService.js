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
   			console.log(configService.urlObj.user_login);
   			crudService.postApi($requestParams, configService.urlObj.user_login).then(function(resp){
				deferred.resolve(resp);
   			},function(resp){
				deferred.reject(resp)
   			});
   			return deferred.promise;
   		}
   		function getList(){
   			var deferred = $q.defer();
   			crudService.getApi(configService.urlObj.phone_list).then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){

   			});
   			return deferred.promise;
   		}
   		return {
   			doAuthentication: doAuthentication,
   			getList: getList
   		}
 
   }]);
