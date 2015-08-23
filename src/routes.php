<?php

// Routes Configuration

$app->post('/api/user/login', 'PhoneDirectory\Controller\ApiUserController::loginAction');
$app->get('/', 'PhoneDirectory\Controller\IndexController::indexAction');
$app->post('/api/phone/add', 'PhoneDirectory\Controller\ApiPhoneController::addUpdateAction');
$app->get('/api/phone/list', 'PhoneDirectory\Controller\ApiPhoneController::listAction');
$app->put('/api/phone/edit/{id}', 'PhoneDirectory\Controller\ApiPhoneController::addUpdateAction');    
$app->delete('/api/phone/delete/{id}', 'PhoneDirectory\Controller\ApiPhoneController::deleteAction'); 
$app->get('/api/user/logout', 'PhoneDirectory\Controller\ApiUserController::logoutAction');
$app->get('/api/phone/search', 'PhoneDirectory\Controller\ApiPhoneController::searchAction');


