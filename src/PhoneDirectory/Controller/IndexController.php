<?php

namespace PhoneDirectory\Controller;

//use MusicBox\Entity\Artist;
//use MusicBox\Form\Type\ArtistType;
use Silex\Application;
//use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $data =array();
        return $app['twig']->render('index.html.twig', $data);
    }

    /*public function addAction(Request $request, Application $app)
    {
        $artist = new Artist();
        $form = $app['form.factory']->create(new ArtistType(), $artist);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.artist']->save($artist);
                $message = 'The artist ' . $artist->getName() . ' has been saved.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('admin_artist_edit', array('artist' => $artist->getId()));
                return $app->redirect($redirect);
            }
        }

        $data = array(
            'form' => $form->createView(),
            'title' => 'Add new artist',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function editAction(Request $request, Application $app)
    {
        $artist = $request->attributes->get('artist');
        if (!$artist) {
            $app->abort(404, 'The requested artist was not found.');
        }
        $form = $app['form.factory']->create(new ArtistType(), $artist);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.artist']->save($artist);
                $message = 'The artist ' . $artist->getName() . ' has been saved.';
                $app['session']->getFlashBag()->add('success', $message);
            }
        }

        $data = array(
            'form' => $form->createView(),
            'title' => 'Edit artist ' . $artist->getName(),
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function deleteAction(Request $request, Application $app)
    {
        $artist = $request->attributes->get('artist');
        if (!$artist) {
            $app->abort(404, 'The requested artist was not found.');
        }

        $app['repository.artist']->delete($artist);
        return $app->redirect($app['url_generator']->generate('admin_artists'));
    }*/
}
