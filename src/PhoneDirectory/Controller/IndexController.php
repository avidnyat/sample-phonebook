<?php

namespace PhoneDirectory\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $data =array();
        return $app['twig']->render('index.html.twig', $data);
    }


}
