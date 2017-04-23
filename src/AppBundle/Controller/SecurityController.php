<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Forms\LoginForm;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\user;



class SecurityController extends Controller
{

    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);

        return $this->render(
            'admin/login.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $error,
            )
        );
    }


    /**
     * @Route("/new", name="CreatAdmin")
     */
    public function NewAdmin()
    {
        $factory = $this->get('security.encoder_factory');
        $em = $this->getDoctrine()->getManager();
        $admin = new user();
        $admin->setnick('Julien');
        $admin->setpass('wrxpymwww3cpf7');

        $encoder = $factory->getEncoder($admin);
        $password = $encoder->encodePassword('wrxpymww3cpf7', $admin->getSalt());
        $admin->setpass($password);
        $em->persist($admin);
        $em->flush($admin);

        return new Response('<html><body>Admin created!</body></html>');
    }

  
     /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }

   


}