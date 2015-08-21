<?php

// Routes Configuration

$app->post('/api/user/login', 'PhoneDirectory\Controller\ApiUserController::loginAction');

$app->get('/', 'PhoneDirectory\Controller\IndexController::indexAction');
$app->post('/api/phone/add', 'PhoneDirectory\Controller\ApiPhoneController::addUpdateAction');
$app->get('/api/phone/list', 'PhoneDirectory\Controller\ApiPhoneController::listAction');
$app->put('/api/phone/edit', 'PhoneDirectory\Controller\ApiPhoneController::addUpdateAction');    
$app->delete('/api/phone/delete/{id}', 'PhoneDirectory\Controller\ApiPhoneController::deleteAction'); 


