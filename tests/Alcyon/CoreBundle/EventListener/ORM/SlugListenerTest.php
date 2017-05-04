<?php

namespace Tests\Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\MappedSuperclass\Slug;
use Alcyon\CoreBundle\EventListener\ORM\SlugListener;
use Alcyon\CoreBundle\Service\Slugify;
use Doctrine\ORM\Event\LifecycleEventArgs;
use PHPUnit\Framework\TestCase;

class SlugListenerTest extends TestCase
{
    private $slugify;

    /**
     * @var SlugListener
     */
    private $slugListener;

    public function setUp()
    {
        $this->slugify = $this->getMockBuilder(Slugify::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->slugListener = new SlugListener($this->slugify);
    }

    public function testConstructor()
    {
        $this->assertSame($this->slugify, $this->slugListener->getSlugify());
    }

    public function testNotslug()
    {
        $event = $this->createLifecycleEventArgs($this->entityNotASlug());
        $this->slugListener->prePersist($event);

        $event = $this->createLifecycleEventArgs($this->entityNotASlug());
        $this->slugListener->preUpdate($event);

        $event = $this->createLifecycleEventArgs($this->entityNotASlug());
        $this->slugListener->postLoad($event);
    }

    private function entityNotASlug()
    {
        $entity = $this->createMock(\stdClass::class)->expects($this->never())->method($this->anything());

        return $entity;
    }

    public function testSlugEntity()
    {

        $event = $this->createLifecycleEventArgs($this->entitySlug());
        $this->slugListener->prePersist($event);

        $event = $this->createLifecycleEventArgs($this->entitySlug());
        $this->slugListener->preUpdate($event);

        $event = $this->createLifecycleEventArgs($this->entitySlug());
        $this->slugListener->postLoad($event);
    }

    private function entitySlug()
    {
        $this->slugify
            ->method('slugify')
            ->with($this->equalTo('Test tilte'))
            ->will($this->returnValue('test_tilte'));

        $entity = $this->createMock(Slug::class);

        $entity->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('Test tilte'));

        $entity->expects($this->once())
            ->method('setSlug')
            ->with($this->equalTo('test_tilte'));

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