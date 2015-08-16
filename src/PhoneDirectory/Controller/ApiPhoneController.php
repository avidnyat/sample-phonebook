<?php

namespace PhoneDirectory\Controller;

use PhoneDirectory\Entity\PhoneBook;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ApiPhoneController
{
    public function addAction(Request $request, Application $app)
    {

    	if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
	        $data = json_decode($request->getContent(), true);

	    }else{
	    	return $app->json(array("500"=>"JSON request required"),500);		
	    }

		if (!$data['name']) {
            return $app->json(array("400"=>'Missing required parameter: name'), 400);
        }
        if (!$data['phone_number']) {
            return $app->json(array("400"=>'Missing required parameter: phone_number'), 400);
        }



        $phoneObj = new PhoneBook();
        $phoneObj->setName($data['name']);
        $phoneObj->setPhoneNumber($data['phone_number']);
        $phoneObj->setAdditionalNotes($data['additional_notes']);
        try{
        	$app['repository.phone_details']->save($phoneObj);	
        }catch(\Exception $e){
        	return $app->json(array("500"=>$e->getMessage()),500);		
        }
        

        $headers = array('Location' => '/api/phone/' . $phoneObj->getId());
        return $app->json(array("201"=>"Created row successfully"), 201, $headers);

    }
    public function listAction(Request $request, Application $app)
    {
    	$phoneObjs = $app['repository.phone_details']->findAll(10, 0);
    	return $app->json($phoneObjs,200);
    }
    public function editAction(Request $request, Application $app){
    	if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
	        $data = json_decode($request->getContent(), true);

	    }else{
	    	return $app->json(array("500"=>"JSON request required"),500);		
	    }

		if (!$data['name']) {
            return $app->json(array("400"=>'Missing required parameter: name'), 400);
        }
        if (!$data['phone_number']) {
            return $app->json(array("400"=>'Missing required parameter: phone_number'), 400);
        }
        $phoneObj = new PhoneBook();
        $phoneObj->setId($data["id"]);
        $phoneObj->setName($data['name']);
        $phoneObj->setPhoneNumber($data['phone_number']);
        $phoneObj->setAdditionalNotes($data['additional_notes']);
        try{
        	$app['repository.phone_details']->save($phoneObj);	
        }catch(\Exception $e){
        	return $app->json(array("500"=>$e->getMessage()),500);		
        }
        return $app->json(array("200"=>"Updated row successfully"), 200);
    }
   
    
}