<?php

namespace Tests\Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\Media;
use Alcyon\CoreBundle\EventListener\ORM\UploadEventListener;
use Alcyon\CoreBundle\Service\FileUploader;
use Alcyon\CoreBundle\Service\Slugify;
use Doctrine\ORM\Event\LifecycleEventArgs;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadEventListenerTest extends TestCase
{
    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * @var Slugify
     */
    private $slugify;

    /**
     * @var UploadEventListener
     */
    private $uploadEvent;

    public function setUp()
    {
        $this->fileUploader = $this->getMockBuilder(FileUploader ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->fileUploader->expects($this->never())
            ->method($this->anything());

        $this->slugify = $this->getMockBuilder(Slugify ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->slugify->expects($this->never())
            ->method($this->anything());

        $this->uploadEvent = new UploadEventListener($this->fileUploader, $this->slugify);
    }

    public function testConstructor()
    {
        $this->assertSame($this->slugify, $this->uploadEvent->getSlugify());
        $this->assertSame($this->fileUploader, $this->uploadEvent->getUploader());
    }

    public function testNotMediaClass()
    {
        $entity = $this->createEntity(\stdClass::class);
        $event = $this->createLifecycleEventArgs($entity);
        $this->uploadEvent->prePersist($event);

        $entity = $this->createEntity(\stdClass::class);
        $event = $this->createLifecycleEventArgs($entity);
        $this->uploadEvent->preUpdate($event);
    }

    /**
     * @dataProvider dataForTestGetFileIsNotAFileClassProvider
     */
    public function testGetFileIsNotUploadedFileClass($file)
    {
        $entity = $this->createEntity(Media::class, $file);
        $event = $this->createLifecycleEventArgs($entity);
        $this->uploadEvent->prePersist($event);

        $entity = $this->createEntity(Media::class, $file);
        $event = $this->createLifecycleEventArgs($entity);
        $this->uploadEvent->preUpdate($event);
    }

    public function testGetFileIsUploadedFileClass()
    {
        $file = $this->getMockBuilder(UploadedFile ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $filename = 'testfilename';
        $fileUploader = $this->getMockBuilder(FileUploader ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fileUploader
            ->expects($this->once())
            ->method('upload')
            ->with($this->equalTo($file),$this->equalTo(null))
            ->will($this->returnValue($filename));
        $entity = $this->createEntity(Media::class, $file, $filename, 'url');
        $event = $this->createLifecycleEventArgs($entity);

        $uploadEvent = new UploadEventListener($fileUploader, $this->slugify);
        $uploadEvent->prePersist($event);
    }

    public function testSlugUrl()
    {
        $clientOriginalName = 'clientOriginalName';
        $file = $this->getMockBuilder(UploadedFile ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects($this->once())
            ->method('getClientOriginalName')
            ->will($this->returnValue($clientOriginalName));

        $filename = 'testfilename';
        $fileUploader = $this->getMockBuilder(FileUploader ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fileUploader
            ->expects($this->once())
            ->method('upload')
            ->with($this->equalTo($file),$this->equalTo(null))
            ->will($this->returnValue($filename));
        $entity = $this->createEntity(Media::class, $file, $filename, null);
        $event = $this->createLifecycleEventArgs($entity);

        $slugify = $this->getMockBuilder(Slugify ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $slugify->expects($this->once())
            ->method('slugify')
            ->with($this->equalTo($clientOriginalName));

        $uploadEvent = new UploadEventListener($fileUploader, $slugify);
        $uploadEvent->prePersist($event);
    }

    public function dataForTestGetFileIsNotAFileClassProvider()
    {
        return [
            [null],
            [''],
            [0],
            ['test'],
            [1],
            [new \stdClass()],
        ];
    }

    private function createEntity($class, $file = null, $fileName = null, $url = null, $slug = null)
    {
        if (null !== $file) {
            $entity = $this->createMock($class);
            $entity->expects($this->once())
                ->method('getFile')
                ->will($this->returnValue($file));

            // Add file to upload
            if($file instanceof UploadedFile) {
                $entity->expects($this->once())
                    ->method('getFolder')
                    ->will($this->returnValue(null));
                $entity->expects($this->once())
                    ->method('setFile')
                    ->with($this->equalTo($fileName));
                $entity->expects($this->once())
                    ->method('getUrl')
                    ->will($this->returnValue($url));

                if(null === $url) {
                    $entity->expects($this->once())
                        ->method('setUrl')
                        ->will($this->returnValue($slug));
                }
            }

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