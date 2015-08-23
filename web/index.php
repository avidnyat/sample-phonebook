<?php

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../app/config/config.php';
require_once __DIR__.'/../src/app.php';
require_once __DIR__.'/../src/routes.php';
//return $app;
$app->run();
