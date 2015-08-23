<?php 

// app file of silex !!!

use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PhoneDirectory\Services\UtilsService;
use PhoneDirectory\Services\ResponseMessagesAndStatuses;
use Silex\Application;
ExceptionHandler::register();
$app = new Silex\Application();
$app['debug'] = true;

// Registering repo for phone_details db table
$app['repository.phone_details'] = $app->share(function ($app) {
    return new PhoneDirectory\Repository\PhoneBookRepository($app['db']);
});

// Registering repo for user db table
$app['repository.user'] = $app->share(function ($app) {
    return new PhoneDirectory\Repository\UserRepository($app['db']);
});

// Registering different providers required
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
	    'host'     => '127.0.0.1',
	    'port'     => '3306',
	    'dbname'   => 'phone_book',
	    'user'     => 'root',
	    'password' => '',
    ),
));

$app->register(new Silex\Provider\SessionServiceProvider(), array(
    'session.storage.save_path' => dirname(__DIR__) . '/tmp/sessions'
));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true,
    ),
    'twig.form.templates' => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
    'twig.path' => array(__DIR__ . '/../app/views')
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/development.log',
));

// Pre execute condition before any controller of API
$app->before(function (Request $request, Application $app) {
    $request->getSession()->start();
    if(($request->getRequestUri()!="/api/user/login") && ($request->getRequestUri()!="/")){
        if(!$app['session']->get('csrf') || $app['session']->get('csrf') != $request->get("csrf")){
            return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::REDIRECT_STATUS_CODE,
                            ResponseMessagesAndStatuses::REQUEST_NOT_ALLOWED
                        )
                       );
        }
    }

});
// Register the error handler.
$app->error(function (\Exception $e, $code) use ($app) {
    

    $response = json_encode(array("code"=>$code,"message"=>$e->getMessage()));
    $app['monolog']->addError($code."==".$e->getMessage());
    return new Response($response, $code);
});

return $app;
