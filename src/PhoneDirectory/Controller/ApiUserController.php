<?php

namespace PhoneDirectory\Controller;

use PhoneDirectory\Entity\PhoneBook;
use Silex\Application;
use PhoneDirectory\Services\UtilsService;
use Symfony\Component\HttpFoundation\Request;
use PhoneDirectory\Services\ResponseMessagesAndStatuses;

class ApiUserController
{
    
    public function logoutAction(Request $request, Application $app){
        $app['session']->set('csrf', "");
        return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::SUCCESS_STATUS_CODE,
                            ResponseMessagesAndStatuses::SUCCESS_OPERATION_MESSAGE
                        ),
                        true
                       );
    }
    public function loginAction(Request $request, Application $app){
        $data =  UtilsService::checkJsonStructure($request);
    	if (($data === -1) || ($data === NULL)) {
	        return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::FATAL_ERROR_STATUS_CODE,
                            ResponseMessagesAndStatuses::JSON_FORMAT_WRONG_MESSAGE
                        )
                       );
	    }
        $checkMissingDataOrSendResponse = UtilsService::checkRequestParamsMissing(
                                                                $data, array(
                                                                            'username', 
                                                                            'password' 
                                                                            ), 
                                                                    $app);
        if($checkMissingDataOrSendResponse !== -1)
            return $checkMissingDataOrSendResponse;
		
        try{
            $resultData = $app['repository.user']->authenticate($data, $app);
        	if (!$resultData){
                return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::MISSING_PARAMS_STATUS_CODE,
                            ResponseMessagesAndStatuses::INVALID_CREDENTIALS
                        )
                       );

            }	
        }catch(\Exception $e){
        	return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::FATAL_ERROR_STATUS_CODE,
                            $e->getMessage()
                        )
                       );
        }
        

        return UtilsService::createAndSendResponse($app, 
                        $resultData,
                        true
                       );
        

    }
}