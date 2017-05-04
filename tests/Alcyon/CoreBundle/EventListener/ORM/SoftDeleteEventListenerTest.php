<?php

namespace Tests\Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\MappedSuperclass\SoftDeleteInterface;
use Alcyon\CoreBundle\EventListener\ORM\SoftDeleteEventListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SoftDeleteEventListenerTest extends TestCase
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var SoftDeleteEventListener
     */
    private $softDeleteEvent;

    public function setUp()
    {
        $this->tokenStorage = $this->createMock(TokenStorageInterface::class);
        $this->softDeleteEvent = new SoftDeleteEventListener($this->tokenStorage);
    }

    public function testConstructor()
    {
        $this->assertSame($this->tokenStorage, $this->softDeleteEvent->getTokenStorage());
    }

    public function testEventWithoutEntities()
    {
        $this->runEvent([]);
    }

    private function runEvent($entities)
    {
        $unitOfWork = $this->getMockBuilder(UnitOfWork::class)
            ->disableOriginalConstructor()
            ->getMock();
        $unitOfWork->expects($this->once())
            ->method('getScheduledEntityDeletions')
            ->will($this->returnValue($entities));

        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())
            ->method('getUnitOfWork')
            ->will($this->returnValue($unitOfWork));

        $event = $this->getMockBuilder(PreFlushEventArgs::class)
            ->disableOriginalConstructor()
            ->getMock();
        $event->expects($this->once())
            ->method('getEntityManager')
            ->will($this->returnValue($em));

        $this->softDeleteEvent->preFlush($event);
    }

    public function testEntitieNotUseSoftDeleteTrait()
    {
        $entities = [$this->createMock(\stdClass::class)];

        $this->runEvent($entities);
    }

    public function testEntitieHaveDateTime()
    {
        $dateTime = $this->createMock(\DateTime::class);

        $entity = $this->createMock(SoftDeleteInterface::class);
        $entity->expects($this->once())
            ->method('getDeletedAt')
            ->will($this->returnValue($dateTime));

        $entities = [$entity];

        $this->runEvent($entities);
    }

    public function testEntitieNotHaveDateTime()
    {
        $user = 'UserName';

        $token = $this->createMock(TokenInterface::class);

        $token->expects($this->once())
            ->method('getUsername')
            ->will($this->returnValue($user));

        $this->tokenStorage->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue($token));

        $entity = $this->createMock(SoftDeleteInterface::class);
        $entity->expects($this->once())
            ->method('getDeletedAt')
            ->will($this->returnValue(false));

        $entity->expects($this->once())
            ->method('setDeletedAt')
            ->with($this->isInstanceOf(\DateTime::class));

        $entity->expects($this->once())
            ->method('setDeletedBy')
            ->with($this->equalTo($user));

        $entities = [$entity];

        $this->runEvent($entities);
    }
}