<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Forms\MailForm;
use mysql_real_escape_string;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')
            ->FindOnly(3);

        return $this->render('default/index.html.twig', array(
            'articles' => $article
        ));
    }

    /**
     * @Route("/about", name="about")
     */
    public function indexAbout()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/membership", name="membership")
     */
    public function indexMembership()
    {
        return $this->render('default/membership.html.twig');
    }

    /**
     * @Route("/kontakt", name="Kontakt")
     */
    public function SendEmail(Request $request)
    {

        $form = $this->createForm(MailForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $Email = $form['Email']->getData();
            $Temat = $form['Temat']->getData();
            $Tekst = $form['Tekst']->getData();

            $message = \Swift_Message::newInstance()
                ->setSubject($Temat)
                ->setFrom($Email)
                ->setTo('rafak@o2.pl')
                ->setBody($Tekst);

            $this->addFlash('success',
                sprintf('Udało się wysłać Maila!')
            );
            
            $this->get('mailer')->send($message);

            return $this->render('default/Contact.html.twig', array(
                'MailForm' => $form->createView()
            ));
        }


        return $this->render('default/Contact.html.twig', array(
            'MailForm' => $form->createView()
        ));
    }

    /**
     * @Route("/galeria", name="gallery")
     */
    public function GalleryAction()
    {
        $em = $this->getDoctrine()->getManager();

        $zdjecia = $em->getRepository('AppBundle:photo')
                   ->findAll();

        return $this->render('default/gallery.html.twig', array(
            'zdjecia' => $zdjecia
        ));
    }

   /**
     * @Route("galeria/{name}", name="gallery-single")
     */
    public function GalleryActionNext($name)
    {
        $em = $this->getDoctrine()->getManager();

        $dir = '%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia';

        $files1 = scandir($dir);
        unset($files1[0]);
        unset($files1[1]);
        sort($files1);

        if($files1==null)
        {
           $files1[0] = '1.jpg';
        }

        $length= count($files1)-1;
        return $this->render('default/Single-gallery.html.twig', array(
             'zdjecia' => $files1,
             'length' =>$length,
             'name' => $name
            ));
    }

}
