<?php

namespace Chat\ChatBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;

use Chat\ChatBundle\Entity\User;

class ActivityListener
{
	private $securityContext;
	private $entityManager;

	public function __construct(SecurityContext $securityContext, EntityManager $entityManager)
	{
		$this->securityContext = $securityContext;
		$this->entityManager = $entityManager;
	}

	public function onKernelController()
	{
		if ($this->securityContext->getToken()) {
			$user = $this->securityContext->getToken()->getUser();

			if ($user instanceOf User) {
				$user->setLastActivity(new \DateTime());
				$this->entityManager->persist($user);
				$this->entityManager->flush();
			}
		}
	}
}