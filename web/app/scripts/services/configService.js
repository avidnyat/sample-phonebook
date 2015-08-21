'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the webApp
 */
angular.module('webApp.Services',[])
  .service('configService',function () {
   		var urlObj = {
   			user_login: '/user/login',
   			phone_list: '/data/list.json'
   		}
   		var baseUrl = "http://localhost/api"
   		return {
   			urlObj : urlObj,
   			baseUrl: baseUrl
   		}

   });
