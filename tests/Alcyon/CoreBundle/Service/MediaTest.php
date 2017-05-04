<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Repository\MediaRepository;
use Alcyon\CoreBundle\Service\Media;
use Alcyon\CoreBundle\Service\TryDns;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Tests\Resources\Tools;

class MediaTest extends TestCase
{
    const url = 'test_url';

    private $em;
    private $tryDns;
    /**
     * @var Media
     */
    private $mediaService;

    public function setUp()
    {
        $this->em = $this->getMockBuilder(EntityManager ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->tryDns = $this->getMockBuilder(TryDns ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mediaService = new Media($this->em, $this->tryDns, Tools::folderImagePath);

    }

    public function testConstructor()
    {
        $this->assertSame($this->em, $this->mediaService->getEm());
        $this->assertSame($this->tryDns, $this->mediaService->getTryDns());
        $this->assertSame(Tools::folderImagePath, $this->mediaService->getTargetPath());
    }

    public function testGetMediaWithoutDns()
    {
        $media = $this->getMockBuilder(\Alcyon\CoreBundle\Entity\Media ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->addRepositoryToEntityManager(self::url, $media);

        $this->assertSame($media, $this->mediaService->getMedia(self::url, false));
    }

    private function addRepositoryToEntityManager($url, $media)
    {
        $repository = $this->getMockBuilder(MediaRepository ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())
            ->method('findMediaByUrl')
            ->with($this->equalTo($url))
            ->will($this->returnValue([$media]));

        $this->em->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo('AlcyonCoreBundle:Media'))
            ->will($this->returnValue($repository));
    }

    public function testGetMediaOkWithDns()
    {
        $getDnss = $this->getMockBuilder(Collection ::class)->getMock();
        $media = $this->getMockBuilder(\Alcyon\CoreBundle\Entity\Media ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $media->expects($this->once())
            ->method('getDnss')
            ->will($this->returnValue($getDnss));
        $this->tryDns->expects($this->once())
            ->method('tryDns')
            ->with($this->equalTo($getDnss))
            ->will($this->returnValue(true));
        $this->addRepositoryToEntityManager(self::url, $media);

        $this->assertSame($media, $this->mediaService->getMedia(self::url, true));
    }

    public function testGetMediaNotOkWithDns()
    {
        $getDnss = $this->getMockBuilder(Collection ::class)->getMock();
        $media = $this->getMockBuilder(\Alcyon\CoreBundle\Entity\Media ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $media->expects($this->once())
            ->method('getDnss')
            ->will($this->returnValue($getDnss));
        $this->tryDns->expects($this->once())
            ->method('tryDns')
            ->with($this->equalTo($getDnss))
            ->will($this->returnValue(false));
        $this->addRepositoryToEntityManager(self::url, $media);

        $this->assertSame(null, $this->mediaService->getMedia(self::url, true));
    }
}