<?php
namespace PhoneDirectory\Services;

use PhoneDirectory\Services\ResponseMessagesAndStatuses;
class UtilsService{

	public function checkJsonStructure($request){
		
		$data = (0 === strpos($request->headers->get('Content-Type'), 'application/json'))? 
			json_decode($request->getContent(), true):-1;		
	    
	    return $data;
	}
	public function createAndSendResponse($app, $responseArray, $successflag = false){
		if($successflag == true){
			return $app->json($responseArray, ResponseMessagesAndStatuses::SUCCESS_STATUS_CODE);
		}
		if($app['debug'] != true){
			$responseArray = array(
					ResponseMessagesAndStatuses::FATAL_ERROR_STATUS_CODE,
					ResponseMessagesAndStatuses::SOMETHING_WENT_WRONG_MESSAGE
				);
		}
		return $app->json(array($responseArray[0], $responseArray[1]), $responseArray[0]);
	}
	public function checkRequestParamsMissing($data, $requestArray, $app){
		$paramArray = array();
		$flag = false;
		foreach ($requestArray as $key => $value) {
			if(!$data[$value]){
				array_push($paramArray, $value);
				$flag = true;
			}
		}
		$responseArray = array(ResponseMessagesAndStatuses::MISSING_PARAMS_STATUS_CODE,
							ResponseMessagesAndStatuses::MISSING_PARAMS_MESSSAGE . $paramArray.join(","));
		if($flag === true){
			return $this->createAndSendResponse($app, $responseArray);	
		}else{
			return -1;
		}
		
	}

}