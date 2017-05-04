<?php

namespace Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\Media;
use Alcyon\CoreBundle\EventListener\EventListener;
use Alcyon\CoreBundle\Service\FileUploader;
use Alcyon\CoreBundle\Service\Slugify;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadEventListener extends EventListener
{
    private $uploader;
    private $slugify;

    /**
     * @return FileUploader
     */
    public function getUploader(): FileUploader
    {
        return $this->uploader;
    }

    /**
     * @return Slugify
     */
    public function getSlugify(): Slugify
    {
        return $this->slugify;
    }

    public function __construct(FileUploader $uploader, Slugify $slugify)
    {
        $this->uploader = $uploader;
        $this->slugify = $slugify;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Media entities
        if(!$entity instanceof Media) {
            return;
        }

        $file = $entity->getFile();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        // Upload file
        $fileName = $this->uploader->upload($file,
                                            $entity->getFolder());
        $entity->setFile($fileName);
        
        // Compute url if needed
        if(null == $entity->getUrl()) {
            $entity->setUrl($this->slugify->slugify($file->getClientOriginalName()));
        }
    }

}