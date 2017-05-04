<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\FileUploader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderTest extends TestCase
{
    public function testGetterSetter()
    {
        $targetDir = 'targetDir';
        $fileUploder = new FileUploader($targetDir);

        $this->assertSame($targetDir, $fileUploder->getTargetDir());
    }

    public function testUploadFile()
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)
            ->disableOriginalConstructor()
            ->getMock();

        $uploadedFile->expects($this->once())
            ->method('guessExtension')
            ->will($this->returnValue('ext'));

        $uploadedFile->expects($this->once())
            ->method('move');

        $targetDir = __DIR__.'/../../../../var/test';
        if(is_dir($targetDir))
            rmdir($targetDir);
        $fileUploder = new FileUploader($targetDir);
        $this->assertTrue(is_string($fileUploder->upload($uploadedFile)));
        rmdir($targetDir);
    }
}