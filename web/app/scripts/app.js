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
    'webApp.Services'
    
  ])
  .run(['configService', 'Restangular', function(configService , Restangular){
      //Restangular.setBaseUrl(configService.baseUrl);
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
  }])

  .config(function ($routeProvider, $jqueryValidateProvider) {
    
    $routeProvider
      .when('/', {
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl',
        controllerAs: 'login'
      })
      .when('/home', {
        templateUrl: 'views/home.html',
        controller: 'HomeCtrl',
        controllerAs: 'home'
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
         $("#"+error.element.id).next().next().addClass("hide");
          $("#"+error.element.id).addClass("error");
          $("#"+error.element.id).next().removeClass("hide");
       
     }
   },
   success: function(label) {
            $("#"+label[0].htmlFor).next().addClass("hide");
            $("#"+label[0].htmlFor).next().next().removeClass("hide");
        },
  });

  });
