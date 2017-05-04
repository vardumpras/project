<?php

namespace Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\MappedSuperclass\AuthorInterface;
use Alcyon\CoreBundle\EventListener\EventListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthorEventListener extends EventListener
{
    private $tokenStorage;

    /**
     * @return TokenStorageInterface
     */
    public function getTokenStorage(): TokenStorageInterface
    {
        return $this->tokenStorage;
    }

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->authorUpdate($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->authorUpdate($entity);
    }

    private function authorUpdate($entity)
    {
        if(!$entity instanceof AuthorInterface) {
            return;
        }

        $entity->setUpdatedAt(new \DateTime());
        $author = $this->tokenStorage->getToken();
        $entity->setUpdatedBy($author ? $author->getUsername() : '');
    }
}