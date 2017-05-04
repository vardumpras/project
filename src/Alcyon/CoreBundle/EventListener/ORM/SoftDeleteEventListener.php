<?php
namespace Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\MappedSuperclass\SoftDeleteInterface;
use Alcyon\CoreBundle\EventListener\EventListener;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SoftDeleteEventListener extends EventListener
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

    public function preFlush(PreFlushEventArgs $event)
    {
        $em = $event->getEntityManager();

        foreach ($em->getUnitOfWork()->getScheduledEntityDeletions() as $entity) {

            // force  only works for SoftDelete entities
            if (!$entity instanceof SoftDeleteInterface) {
                continue;
            }

            if ($entity->getDeletedAt() instanceof \Datetime) {
                continue;
            } else {

                $entity->setDeletedAt(new \DateTime());
                $author = $this->tokenStorage->getToken();
                $entity->setDeletedBy($author ? $author->getUsername() : '');

                $em->merge($entity);
                $em->persist($entity);
            }
        }
    }
}