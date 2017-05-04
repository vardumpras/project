<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\UriToFile;
use Alcyon\CoreBundle\Entity\Media as MediaEntity;
use Alcyon\CoreBundle\Service\Media;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\Resources\Tools;

class UriToFileTest extends TestCase
{
    private $mediaService;
    private $uploadPath = '';
    private $webPath = '';

    private function getService() : UriToFile
    {
        $this->mediaService =  $this->getMockBuilder(Media::class)
            ->disableOriginalConstructor()
            ->getMock();

        return new UriToFile($this->mediaService, $this->uploadPath, $this->webPath);
    }

    public function testConstructor()
    {
        $uriToFile = $this->getService();

        $this->assertSame($this->mediaService, $uriToFile->getMediaService());
        $this->assertSame($this->uploadPath, $uriToFile->getUploadPath());
        $this->assertSame($this->webPath, $uriToFile->getWebPath());
    }

    public function testNotFoundHttpException()
    {
        $this->expectException(NotFoundHttpException::class);

        $this->getService()->find('');
    }

    public function testWebPath()
    {
        $this->webPath = Tools::folderImagePath;
        $this->uploadPath = '------------';
        $this->assertInstanceOf(File::class, $this->getService()->find('test.bmp'));
    }

    public function testUploadPath()
    {
        $this->webPath = '-----------';
        $this->uploadPath = Tools::folderImagePath;
        $this->assertInstanceOf(File::class, $this->getService()->find('test.bmp'));
    }

    public function testValideMediaPath()
    {
        $this->webPath = '------------';
        $this->uploadPath = '------------';

        $service = $this->getService();
        $file = $this->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock();

        $media = $this->getMockBuilder(MediaEntity::class)
            ->disableOriginalConstructor()
            ->getMock();

        $media->expects($this->exactly(2))
            ->method('getFile')
            ->will($this->returnValue($file));

        $this->mediaService->expects($this->once())
            ->method('getMedia')
            ->will($this->returnValue($media));

        $this->assertSame($file, $service->find('test.bmp'));
    }
}