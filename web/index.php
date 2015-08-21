<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
require_once __DIR__.'/../app/config/config.php';
require_once __DIR__.'/../src/app.php';
require_once __DIR__.'/../src/routes.php';

$app->run();
