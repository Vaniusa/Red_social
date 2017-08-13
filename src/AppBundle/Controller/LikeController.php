<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use BackendBundle\Entity\Publication;
use BackendBundle\Entity\User;
use BackendBundle\Entity\Like;

class LikeController extends Controller
{
    public function likeAction($id = null)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $publication_repo = $em->getRepository('BackendBundle:Publication');
        $publication = $publication_repo->find($id);

        $like = new Like();
        $like->setUser($user);
        $like->setPublication($publication);
        $em->persist($like);
        $flush = $em->flush();

        if ($flush == null) {
            $status = "Te gusta esta publicacion";
        } else {
            $status = "No se ha podido guardar el me gusta";
        }
        return new Response($status);
    }
}
