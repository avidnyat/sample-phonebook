
<?php 
use Symfony\Component\Debug\ExceptionHandler;

ExceptionHandler::register();
// Register repositories.
$app['repository.phone_details'] = $app->share(function ($app) {
    return new PhoneDirectory\Repository\PhoneBookRepository($app['db']);
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
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true,
    ),
    'twig.form.templates' => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
    'twig.path' => array(__DIR__ . '/../app/views')
));