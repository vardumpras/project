<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\ImagePathToResource;
use Tests\Resources\Tools;
use PHPUnit\Framework\TestCase;

class ImagePathToResourceTest extends TestCase
{
    public function testGetResourceVaid()
    {
        $imagePathToResource = new ImagePathToResource();

        // Test 3 images
        $this->assertNotFalse($imagePathToResource->getResource(Tools::folderImagePath . 'test.jpg'));
        $this->assertNotFalse($imagePathToResource->getResource(Tools::folderImagePath . 'test.png'));
        $this->assertNotFalse($imagePathToResource->getResource(Tools::folderImagePath . 'test.gif'));
    }

    public function testGetResourceResourceNotSupported()
    {
        $imagePathToResource = new ImagePathToResource();

        $this->assertFalse($imagePathToResource->getResource(Tools::folderImagePath . 'test.bmp'));
    }

    public function testGetResourceResourceNotValid()
    {
        $imagePathToResource = new ImagePathToResource();


        $this->assertFalse($imagePathToResource->getResource(Tools::folderImagePath . 'test.txt'));
    }
}