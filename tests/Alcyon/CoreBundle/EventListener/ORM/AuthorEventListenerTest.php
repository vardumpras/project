<?php

namespace Tests\Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\MappedSuperclass\AuthorInterface;
use Alcyon\CoreBundle\EventListener\ORM\AuthorEventListener;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthorEventListenerTest extends TestCase
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthorEventListener
     */
    private $authorEventListener;

    public function setUp()
    {
        $this->tokenStorage = $this->createMock(TokenStorageInterface::class);
        $this->authorEventListener = new AuthorEventListener($this->tokenStorage);
    }

    public function testConstructor()
    {
        $this->assertSame($this->tokenStorage, $this->authorEventListener->getTokenStorage());
    }

    public function testNotAuthor()
    {
        $event = $this->createLifecycleEventArgs($this->entityNotAuthor());
        $this->authorEventListener->prePersist($event);

        $event = $this->createLifecycleEventArgs($this->entityNotAuthor());
        $this->authorEventListener->preUpdate($event);
    }

    private function entityNotAuthor()
    {
        $entity = $this->createMock(\stdClass::class)->expects($this->never())->method($this->anything());

        return $entity;
    }

    public function testAuthorEntity()
    {

        $event = $this->createLifecycleEventArgs($this->entityAuthor());
        $this->authorEventListener->prePersist($event);

        $event = $this->createLifecycleEventArgs($this->entityAuthor());
        $this->authorEventListener->preUpdate($event);
    }

    private function entityAuthor()
    {
        $user = 'UserName';

        $token = $this->createMock(TokenInterface::class);

        $token->method('getUsername')
            ->will($this->returnValue($user));

        $this->tokenStorage
            ->method('getToken')
            ->will($this->returnValue($token));

        $entity = $this->createMock(AuthorInterface::class);

        $entity->expects($this->once())
            ->method('setUpdatedAt')
            ->with($this->isInstanceOf(\DateTime::class));

        $entity->expects($this->once())
            ->method('setUpdatedBy')
            ->with($this->equalTo($user));

        return $entity;
    }

    private function createLifecycleEventArgs($entity)
    {
        $event = $this->getMockBuilder(LifecycleEventArgs::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue($entity));

        return $event;
    }
}


