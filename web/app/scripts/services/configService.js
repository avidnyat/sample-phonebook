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

  	    if(window.environment == "dev"){
  	    	var urlObj = {
	   			user_login: '/user/login',
	   			phone_list: '/data/list.json',
	   			phone_add:  '/data/list.json',
	   			phone_edit: '/data/list.json',
	   			phone_delete: '/data/list.json',
	   			user_logout: '/user/logout',
	   			phone_search: 'data/listSearch.json'
	   		}	
	   		var baseUrl = "http://localhost:9000"
  	    }else{
  	    	var urlObj = {
	   			user_login: '/user/login',
	   			phone_list: '/phone/list',
	   			phone_add:  '/phone/add',
	   			phone_edit: '/phone/edit',
	   			phone_delete: 'phone/delete',
	   			user_logout: '/user/logout',
	   			phone_search: '/phone/search'
	   		}
	   		var baseUrl = "http://localhost/api"
  	    }
   		
   		
   		return {
   			urlObj : urlObj,
   			baseUrl: baseUrl
   		}

   });
