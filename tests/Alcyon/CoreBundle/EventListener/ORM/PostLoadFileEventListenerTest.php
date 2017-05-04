<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 10/03/2017
 * Time: 09:07
 */

namespace Tests\Alcyon\CoreBundle\EventListener\ORM;


use Alcyon\CoreBundle\Entity\Media;
use Alcyon\CoreBundle\EventListener\ORM\PostLoadFileEventListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;
use Tests\Resources\Tools;

class PostLoadFileEventListenerTest extends TestCase
{
    /**
     * @var PostLoadFileEventListener
     */
    private $postloadEvent;

    public function setUp()
    {
        $this->postloadEvent = new PostLoadFileEventListener(Tools::folderImagePath);
    }

    public function testConstructor()
    {
        $this->assertSame(Tools::folderImagePath, $this->postloadEvent->getTargetPath());
    }

    public function testNotMediaClass()
    {
        $entity = $this->createEntity(\stdClass::class);

        $event = $this->createLifecycleEventArgs($entity);
        $this->postloadEvent->postLoad($event);
    }

    public function testGetFileIsEmpty()
    {
        $file = '';
        $entity = $this->createEntity(Media::class, $file);

        $event = $this->createLifecycleEventArgs($entity);
        $this->postloadEvent->postLoad($event);
    }

    public function testGetFileIsNotAString()
    {
        $file = new \stdClass();
        $entity = $this->createEntity(Media::class, $file);

        $event = $this->createLifecycleEventArgs($entity);
        $this->postloadEvent->postLoad($event);
    }

    public function testGetFileIsAString()
    {
        $file = 'test.jpg';
        $entity = $this->createEntity(Media::class, $file);
        $entity->expects($this->once())
            ->method('getFolder')
            ->will($this->returnValue(''));

        $entity->expects($this->once())
            ->method('setFile')
            ->with($this->isInstanceOf(File::class));

        $event = $this->createLifecycleEventArgs($entity);
        $this->postloadEvent->postLoad($event);
    }

    private function createEntity($class, $file = null)
    {
        if (null !== $file) {
            $entity = $this->createMock($class);
            $entity->expects($this->once())
                ->method('getFile')
                ->will($this->returnValue($file));

            return $entity;

        } else {
            return $this->createMock($class)->expects($this->never())->method($this->anything());
        }
    }

    private function createLifecycleEventArgs($entity)
    {
        $event = $this->getMockBuilder(LifecycleEventArgs ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue($entity));

        return $event;
    }
}