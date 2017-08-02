<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("BackendBundle:User")->find(1);
        var_dump($user);
        die();

        return $this->render('BackendBundle:Default:index.html.twig');
    }
}
