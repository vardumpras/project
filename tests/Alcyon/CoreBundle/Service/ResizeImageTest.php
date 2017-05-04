<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\ImagePathToResource;
use Alcyon\CoreBundle\Service\ResizeImage;
use PHPUnit\Framework\TestCase;
use Tests\Resources\Tools;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;

class ResizeImageTest extends TestCase
{
    private $resizeImage;
    private $imagePath;
    private $cache;
    private $cacheItem;

    public function setUp()
    {
        $this->imagePath = $this->getMockBuilder(ImagePathToResource ::class)->getMock();

        $this->cacheItem =  $this->getMockBuilder(CacheItemInterface::class)->getMock();
        $this->cache = $this->getMockBuilder(CacheItemPoolInterface::class)->getMock();
        $this->cache->expects($this->once())
            ->method('getItem')
            ->will($this->returnValue($this->cacheItem));


        $this->resizeImage = new ResizeImage($this->imagePath, $this->cache);
    }

    public function testNotAValidImage()
    {
        // Not a file
        $this->assertNull($this->resizeImage->resize('source', 20, 20, 'destination folder'));

        // Not a image
        $this->assertNull($this->resizeImage->resize(Tools::folderImagePath . 'test.txt', 20, 20, 'destination folder'));

        // Not supported image
        $this->imagePath->expects($this->once())
            ->method('getResource')
            ->with($this->equalTo(Tools::folderImagePath . 'test.bmp'))
            ->will($this->returnValue(false));


        $this->assertNull($this->resizeImage->resize(Tools::folderImagePath . 'test.bmp', 20, 20, 'destination folder'));
    }

    public function testImageCached()
    {
        $cachedItem = 'cachedItem';

        $this->cacheItem->expects($this->once())
            ->method('get')
            ->will($this->returnValue($cachedItem));

        $this->assertSame($cachedItem, $this->resizeImage->resize(Tools::folderImagePath . 'test.bmp', 20, 20, 'destination folder'));
    }
    /**
     * @dataProvider dataForTestValidImage
     */
    public function testValidImage($source, $w, $h, $crop)
    {
        $tempFolder = Tools::folderImagePath . 'tmp/';

        $this->cacheItem->expects($this->once())
            ->method('get')
            ->will($this->returnValue(null));

        $this->cacheItem->expects($this->once())
            ->method('set');
        $this->cache->expects($this->once())
            ->method('save')
            ->with($this->cacheItem);
        $this->cache->expects($this->once())
            ->method('commit');

        $this->imagePath->expects($this->once())
            ->method('getResource')
            ->with($this->equalTo($source))
            ->will($this->returnValue($this->getResource($source)));

        $this->assertNotNull($this->resizeImage->resize($source, $w, $h, $tempFolder . 'tmp.jpg', $crop));

        // Remove temp folder
        @unlink($tempFolder . 'tmp.jpg');
        @rmdir($tempFolder);
    }

    private function getResource($source)
    {
        $imgType = exif_imagetype($source);

        switch ($imgType) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($source);
                break;
            case IMAGETYPE_PNG:
                return imagecreatefrompng($source);
                break;
            case IMAGETYPE_GIF:
                return imagecreatefromgif($source);
                break;
        }

        return false;
    }

    public function testImageMaxSize()
    {
        $tempFolder = Tools::folderImagePath . 'tmp/';
        $source = Tools::folderImagePath . 'test.jpg';

        $this->imagePath->expects($this->once())
            ->method('getResource')
            ->with($this->equalTo($source))
            ->will($this->returnValue($this->getResource($source)));

        $this->assertNotNull($this->resizeImage->resize($source,
            ResizeImage::MaxWidth * 2,
            ResizeImage::MaxHeight * 2,
            $tempFolder . 'tmp.jpg'));

        list($width, $height) = getimagesize($tempFolder . 'tmp.jpg');
        $this->assertSame(ResizeImage::MaxWidth, $width);
        $this->assertSame(ResizeImage::MaxHeight, $height);

        // Remove temp folder
        @unlink($tempFolder . 'tmp.jpg');
        @rmdir($tempFolder);
    }

    public function dataForTestValidImage()
    {
        return [
            [Tools::folderImagePath . 'test.jpg', 10, 10, true],
            [Tools::folderImagePath . 'test.png', 10, 20, true],
            [Tools::folderImagePath . 'test.jpg', 20, 10, true],
            [Tools::folderImagePath . 'test.png', 10, 10, false],
            [Tools::folderImagePath . 'test.jpg', 10, 20, false],
            [Tools::folderImagePath . 'test.gif', 20, 10, false],
        ];
    }
}