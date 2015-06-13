<?php

// src/Chat/ChatBundle/Controller/UserController.php

namespace Chat\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Chat\ChatBundle\Entity\User;
use Chat\ChatBundle\Form\UserType;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChatBundle:User:index.html.twig');
    }

    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'ChatBundle:User:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );

        //return $this->render('ChatBundle:User:login.html.twig');
    }

    public function signUpAction(Request $request)
    {
    	$user = new User();
    	$userForm = $this->createForm(new UserType, $user);

        $userForm->handleRequest($request);
        if ($userForm->isValid()) {
            $user->setRoles(['ROLE_USER']);

            //récupération du service d'encodage:
            $encoder = $this->container->get('security.password_encoder');

            //cryptage du mot de passe:
            $userEncodedPassword = $encoder->encodePassword($user, $user->getPassword());
            // We replace the "plain" password by the encrypted one
            $user->setPassword($userEncodedPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // connexion automatique de l'utilisateur qui vient de s'inscrire
            // on génère un "jeton" d'authentification (manuellement) 
            $token = new UsernamePasswordToken($user, null, 'main_firewall', $user->getRoles());

            // on l'enregistre dans la couche de sécurité pour l'activer
            $this->get('security.token_storage')->setToken($token);

            $this->get('session')->getFlashBag()->add('notice', 'Votre compte a bien été ajouté.');

            return $this->redirect($this->generateUrl('chat_user_index'));           
        }

        return $this->render('ChatBundle:User:sign-up.html.twig', array(
        	'userForm' => $userForm->createView(),
        	));
    }
}
