<?php

// Controller that handles all phone related APIs

namespace PhoneDirectory\Controller;

use PhoneDirectory\Entity\PhoneBook;
use Silex\Application;
use PhoneDirectory\Services\UtilsService;
use Symfony\Component\HttpFoundation\Request;
use PhoneDirectory\Services\ResponseMessagesAndStatuses;

class ApiPhoneController
{
    // Search API Action
    public function searchAction(Request $request, Application $app){
        $limit = (!$request->get("limit"))? 10:$request->get("limit");
        $offset = (!$request->get("offset"))? 0:$request->get("offset");

        try{
            $phoneObjs = $app['repository.phone_details']->search($limit, $offset, "", $request->get("search"));
            $phoneObjsCount = $app['repository.phone_details']->getSearchCount($limit, $offset, "", $request->get("search"));    
        }catch(\Exception $e){
            return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::FATAL_ERROR_STATUS_CODE,
                            $e->getMessage()
                        )
                       );
        }
        
        $responseArray = array("phoneObjs"=>$phoneObjs,"count"=>$phoneObjsCount);
        return UtilsService::createAndSendResponse($app, $responseArray, true);
    }

    // Add / Update API action
    public function addUpdateAction(Request $request, Application $app){
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
                                                                            'name', 
                                                                            'phone_number' 
                                                                            ), 
                                                                    $app);
        if($checkMissingDataOrSendResponse !== -1)
            return $checkMissingDataOrSendResponse;
		
        $phoneObj = new PhoneBook();
        if(isset($data["id"])){
            $phoneObj->setId($data["id"]);
        }
        $phoneObj->setName($data['name']);
        $phoneObj->setPhoneNumber($data['phone_number']);
        $phoneObj->setAdditionalNotes($data['additional_notes']);
        try{
        	$app['repository.phone_details']->save($phoneObj);	
        }catch(\Exception $e){
        	return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::FATAL_ERROR_STATUS_CODE,
                            $e->getMessage()
                        )
                       );
        }
        

        return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::CREATE_UPDATED_SUCCESS_STATUS_CODE,
                            ResponseMessagesAndStatuses::CREATED_UPDATED_ROW_MESSAGE
                        )
                       );
        

    }
    public function listAction(Request $request, Application $app)
    {
        $limit = (!$request->get("limit"))? 10:$request->get("limit");
        $offset = (!$request->get("offset"))? 0:$request->get("offset");

        try{
            $phoneObjs = $app['repository.phone_details']->findAll($limit, $offset);
            $phoneObjsCount = $app['repository.phone_details']->getCount();    
        }catch(\Exception $e){
            return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::FATAL_ERROR_STATUS_CODE,
                            $e->getMessage()
                        )
                       );
        }
        
        $responseArray = array("phoneObjs"=>$phoneObjs,"count"=>$phoneObjsCount);
        return UtilsService::createAndSendResponse($app, $responseArray, true);
    	
    }
    public function deleteAction(Request $request, Application $app){
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
                                                                            'id'
                                                                            ), 
                                                                    $app);
        if($checkMissingDataOrSendResponse !== -1)
            return $checkMissingDataOrSendResponse;
        try{
            $app['repository.phone_details']->delete($request->get('id'));  
        }catch(\Exception $e){
            return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::FATAL_ERROR_STATUS_CODE,
                            $e->getMessage()
                        )
                       );    
        }
        return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::SUCCESS_STATUS_CODE,
                            ResponseMessagesAndStatuses::DELETED_ROW_MESSAGE
                        )
                       );
    }
    
}