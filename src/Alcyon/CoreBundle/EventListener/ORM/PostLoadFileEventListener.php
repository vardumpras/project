<?php

namespace Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\Media;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;

class PostLoadFileEventListener
{
    private $targetPath;

    /**
     * @return string
     */
    public function getTargetPath()
    {
        return $this->targetPath;
    }

    public function __construct($targetPath)
    {
        $this->targetPath = $targetPath;
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // force file only works for Media entities
        if (!$entity instanceof Media) {
            return;
        }

        // auto load file if needed
        $fileName = $entity->getFile();
        if (is_string($fileName) && '' != $fileName) {
            // Compute path of file
            $subfolder = $entity->getFolder() ??  '';

            // Load file
            $pathFile = $this->targetPath . '/' . $subfolder . '/' . $fileName;
            $entity->setFile(new File($pathFile));
        }
    }
}