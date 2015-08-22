'use strict';

/**
 * @ngdoc function
 * @name webApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the webApp
 */
angular.module('webApp.Services')
	.service('utilsService',['configService', '$q', '$timeout', function ( configService, $q, $timeout) {
    	function showMessage(resp, successFlag){
    		console.log(resp);
    		var msg = "";
    		if(resp.message == undefined){
    			msg = resp.data.message;
    		}else{
    			msg = resp.message;
    		}
    		if(successFlag){
    			$(".success-message").removeClass("hide");
    		}else{
    			$(".error-message").removeClass("hide");
    		}
    		$("#message").html(msg)
    		$( ".messages" ).animate({
						left: "30px",
						}, 1500 ).delay(5000).animate({
							left: "-530px"
						},1500);
			$timeout(function(){
				$(".error-message").addClass("hide");
				$(".success-message").addClass("hide")	
			}, 10000)			
			//$(".success-message , .error-message").delay(8000).addClass("hide");
    	}
    	function escapeHtml(unsafe) {
            if (typeof unsafe == "number") {
                return unsafe;
            }
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function unescapeHtml(safeHtml) {
            if (typeof safeHtml == "string") {
                return safeHtml.replace(/&amp;/g, "&")
                    .replace(/&lt;/g, "<")
                    .replace(/&gt;/g, ">")
                    .replace(/&quot;/g, '"')
                    .replace(/&#039;/g, "'");
            }
            return safeHtml;
        }
        function storeCsrfToken(csrf){
        	document.cookie="csrf="+csrf+";";
        }
        function getCsrfToken(){
        	return getCookie("csrf");
        }
        function deleteCsrfToken(){
        	document.cookie = "csrf=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        }
        function getCookie(cname) {
		    var name = cname + "=";
		    var ca = document.cookie.split(';');
		    for(var i=0; i<ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0)==' ') c = c.substring(1);
		        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		    }
		    return "";
		}
    	return {
    		showMessage: showMessage,
    		escapeHtml: escapeHtml,
    		unescapeHtml: unescapeHtml,
    		storeCsrfToken: storeCsrfToken,
    		getCsrfToken: getCsrfToken,
    		deleteCsrfToken: deleteCsrfToken
    	}
    }]);