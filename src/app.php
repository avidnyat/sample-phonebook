
<?php 
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PhoneDirectory\Services\UtilsService;
use PhoneDirectory\Services\ResponseMessagesAndStatuses;
use Silex\Application;
ExceptionHandler::register();
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Headers: Accept, X-Requested-With');
//header('HTTP/1.1 200 OK', true);
//header('Request-method', 'POST');
// Register repositories.
$app['repository.phone_details'] = $app->share(function ($app) {
    return new PhoneDirectory\Repository\PhoneBookRepository($app['db']);
});
$app['repository.user'] = $app->share(function ($app) {
    return new PhoneDirectory\Repository\UserRepository($app['db']);
});
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


$app->before(function (Request $request, Application $app) {
    $request->getSession()->start();
    if(($request->getRequestUri()!="/api/user/login") && ($request->getRequestUri()!="/")){
        if(!$app['session']->get('user') || $app['session']->get('user') != $request->get("csrf")){
            return UtilsService::createAndSendResponse($app, 
                        array(
                            ResponseMessagesAndStatuses::MISSING_PARAMS_STATUS_CODE,
                            ResponseMessagesAndStatuses::INVALID_CREDENTIALS
                        )
                       );
        }
    }

});
// Register the error handler.
$app->error(function (\Exception $e, $code) use ($app) {
    

    $response = json_encode(array($code,$e->getMessage()));
    $app['monolog']->addError($code."==".$e->getMessage());
    return new Response($response, $code);
});
