'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the webApp
 */
angular.module('webApp.Services')
  .service('crudService',[ 'Restangular', '$q' , function (Restangular, $q) {
   		function postApi(requestParams, objectType){
   			var deferred = $q.defer();
   			console.log(objectType);
   			var postObj = Restangular.all(objectType);
   			postObj.post(requestParams).then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){
   				deferred.reject(resp);
   			});	
   			return deferred.promise;
   		}

   		function getApi(objectType){
   			var deferred = $q.defer();
   			Restangular.all(objectType).getList().then(function(resp){
   				deferred.resolve(resp);
   			},function(resp){

   			});
   			return deferred.promise;
   		}

   		return{
   			postApi: postApi,
   			getApi: getApi
   		}
  }]);
