'use strict';

/**
 * @ngdoc overview
 * @name webApp
 * @description
 * # webApp
 *
 * Main module of the application.
 */
angular
  .module('webApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'angular-jquery-validate',
    'restangular',
    'webApp.Services',
    'angularUtils.directives.dirPagination',
    'webApp.filters'
    
  ])
  .run(['configService', 'Restangular', '$window', '$rootScope', 'apiService','utilsService', function(configService , Restangular, $window, $rootScope, apiService, utilsService){
      Restangular.setBaseUrl(configService.baseUrl);
      Restangular.setDefaultHeaders({
          'Content-Type': 'application/json',
          'Access-Control-Allow-Methods': 'POST, GET, PUT, DELETE, OPTIONS',
          'Access-Control-Allow-Credentials': 'false',
          'Access-Control-Allow-Origin': '*',
          'Access-Control-Allow-Headers': 'X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept',
          'data-type': 'json'
          
      });
      Restangular.setDefaultHttpFields({
        withCredentials: false,
            useXDomain : true,
            headers: {
                'Content-Type': 'application/json'

            }
    });
       Restangular.addRequestInterceptor(function (element) {
                    $(".loader").show();
                    return element;
                });
                Restangular.addResponseInterceptor(function (data, operation, what, url, response, deferred) {
                    $(".loader").hide();
                    if(response.status == 302){
                      $window.location.href =  "/#/"
                    }
                    
                    return data;
                });
                Restangular.setErrorInterceptor(function (response, deferred, responseHandler) {
                    $(".loader").hide();
                    if(response.status == 302){
                      $window.location.href =  "/#/"
                    }
                    
                });
                

  }])

  .config(function ($routeProvider, $jqueryValidateProvider) {
    
    $routeProvider
      .when('/', {
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl',
        controllerAs: 'login',
        resolve: {
          data: ['$rootScope','$q', function($rootScope, $q){
              var deferred =$q.defer();
              $rootScope.logoutFlag = false;
              deferred.resolve("success");
              return deferred.promise;
          }]
          
        }
      })
      .when('/home', {
        templateUrl: 'views/home.html',
        controller: 'HomeCtrl',
        controllerAs: 'home',
        resolve: {
          data: ['$rootScope','$q', 'apiService','utilsService', '$window', function($rootScope, $q, apiService, utilsService, $window){
              var deferred =$q.defer();
              $rootScope.logoutFlag = true;
              $rootScope.logout = function(){
                  apiService.logout().then(function(resp){
                    utilsService.deleteCsrfToken();
                    $window.location.href = "/#/";
                  },function(resp){

                  });
                }
              deferred.resolve("success");
              return deferred.promise;
          }]
          
        }
      })
      .otherwise({
        redirectTo: '/'
      });
    $jqueryValidateProvider.setDefaults({
   errorPlacement: function (error, element) {

   },
   showErrors: function (errorMap, errorList) {
     this.defaultShowErrors();

     
     // add/update tooltips 
     for (var i = 0; i < errorList.length; i++) {
         var error = errorList[i];
         $("#"+error.element.id).parent().next().find(".success-message").addClass("hide");
          $("#"+error.element.id).addClass("error");
          $("#"+error.element.id).parent().next().find(".error-icon").removeClass("hide");
       
     }
   },
   success: function(label) {
            $("#"+label[0].htmlFor).parent().next().find(".error-icon").addClass("hide");
            $("#"+label[0].htmlFor).parent().next().find(".success-message").removeClass("hide");
        },
  });

  });
