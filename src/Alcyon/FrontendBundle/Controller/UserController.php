<?php

namespace Alcyon\FrontendBundle\Controller;

use Alcyon\CoreBundle\Controller\Controller;
use Alcyon\CoreBundle\Entity\User;
use Alcyon\CoreBundle\Form\RegisterType;
use Alcyon\CoreBundle\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $form = $this->createForm(LoginType::class, $user);

        return [
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
                'form'          => $form->createView()
                ];
    }

    /**
     * @Route("/register", name="register")
     * @Template
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $user = $user->setPassword($this
                ->container
                ->get('security.encoder_factory')
                ->getEncoder($user)
                ->encodePassword('toto', $user
                ->getSalt()));

            $em->persist($user);

            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'user saves correctly|trans');

            return $this->redirectToRoute('homepage');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        
    }

    /**
     * @Route("/profil", name="profil")
     * @Template     
     */
    public function profilAction()
    {
        return [];
    }

}