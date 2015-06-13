<?php

namespace Chat\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Chat\ChatBundle\Entity\Message;

class ChatController extends Controller
{
	private function jsonResponse($data=null)
	{
		$response = new Response();
		$response->headers->set('Content-Type', 'application/json');
		$response->setCharset('UTF-8');
		$response->setStatusCode(200);
		$response->setContent(json_encode(array('data' => $data)));

		return $response;
	}

	public function indexAction()
	{
		return $this->render('ChatBundle::chat.html.twig');
	}
	
	public function userListAction()
	{
		$manager = $this->getDoctrine()->getManager();
		/*
		// on enregistre dans la base de données la dernière connexion
		
		$user = $manager->getRepository('ChatBundle:User')->findOneById($this->getUser()->getId());

		if (!$user) {
			throw $this->createNotFoundException('Your account doesn\'t exist.');
		}

		$user->setLastConnection(new \DateTime());
		$manager->persist($user);
		$manager->flush();
*/
		// récupération de la liste des utilisateurs connectés 	
		$repository = $manager->getRepository('ChatBundle:User');

		$time = new \DateTime();
        $time->modify("-5 second");

		$query = $repository->createQueryBuilder('u')
            ->where('u.lastActivity > :time')
            ->setParameter('time', $time)
        	->getQuery();
		$users = $query->getResult();

		$data = array();
		foreach ($users as $key => $user) {
			$data[] = array('username' => $user->getUsername());
		}

		return $this->jsonResponse($data);
	}

	public function messageListAction()
	{
		$repository = $this->getDoctrine()->getRepository('ChatBundle:Message');
		$messages = $repository->findAll();

		$data = array();
		foreach ($messages as $message) {
			$data[] = array(
				'content' 	=> $message->getContent(),
				'date'		=> $message->getDate(),
				'username'	=> $message->getUser()->getUsername()
				);
		}

		return $this->jsonResponse($data);
	}

	public function messageAddAction(Request $request)
	{
		$message = new Message();
		$message->setContent($request->request->get('messageContent'));
		$message->setUser($this->getUser());

		$manager = $this->getDoctrine()->getManager();
		$manager->persist($message);
		$manager->flush();

		return $this->jsonResponse();
	}
}