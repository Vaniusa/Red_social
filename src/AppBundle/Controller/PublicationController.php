<?php
namespace AppBundle\Controller;

use AppBundle\Form\PublicationType;
use BackendBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class PublicationController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // upload image
                $file = $form['image']->getData();
                if (! empty($file) && $file != null) {
                    $ext = $file->guessExtension();
                    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                        $file_name = $user->getId().time().".".$ext;
                        $file->move("uploads/publications/images", $file_name);
                        $publication->setImage($file_name);
                    } else {
                        $publication->setImage(null);
                    }
                } else {
                    $publication->setImage(null);
                }

                // upload document
                $doc = $form['document']->getData();
                if (! empty($doc) && $doc != null) {
                    $ext = $doc->guessExtension();
                    if ($ext == 'pdf') {
                        $file_name = $user->getId().time().".".$ext;
                        $doc->move("uploads/publications/documents", $file_name);
                        $publication->setDocument($file_name);
                    } else {
                        $publication->setDocument(null);
                    }
                } else {
                    $publication->setDocument(null);
                }
                $publication->setUser($user);
                $publication->setCreatedAt(new \DateTime("now"));
                $em->persist($publication);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = 'La pubicacion se ha creado correctamente';
                } else {
                    $status = 'Error al enviar la publicacion';
                }
            } else {
                $status = 'La publicacion no se ha creado, el formulario no es valido';
            }
            $this->session->getFlashBag()->add("status", $status);

            return $this->redirectToRoute('home_publication');
        }

        return $this->render('AppBundle:Publication:home.html.twig', ['form' => $form->createView()]);
    }
}
