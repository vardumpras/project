<?php

namespace Alcyon\CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    /**
     * @return mixed
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file, $folder = null)
    {
        $fileName = sha1(uniqid(mt_rand(), true)) . '.' .$file->guessExtension();

        if(null == $folder)
            $folder = '';
            
        // Create dir if needed
        if(!is_dir($this->targetDir.'/' . $folder ))
            mkdir($this->targetDir.'/' . $folder );
            
        // move file    
        $file->move($this->targetDir . '/' . $folder, $fileName);

        return $fileName;
    }
}
