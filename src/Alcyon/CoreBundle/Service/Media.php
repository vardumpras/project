<?php

namespace Alcyon\CoreBundle\Service;

use Doctrine\ORM\EntityManager;

class Media
{
    protected $em;
    protected $tryDns;
    protected $targetPath;

    public function __construct(EntityManager $em, TryDns $tryDns, $targetPath)
    {
        $this->em = $em;
        $this->tryDns = $tryDns;
        $this->targetPath = $targetPath;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    /**
     * @return TryDns
     */
    public function getTryDns(): TryDns
    {
        return $this->tryDns;
    }

    /**
     * @return mixed
     */
    public function getTargetPath()
    {
        return $this->targetPath;
    }

    public function getMedia($url, $useDns = true)
    {
        $mediaRepository = $this->em
            ->getRepository('AlcyonCoreBundle:Media');

        $medias = $mediaRepository->findMediaByUrl($url);

        foreach ($medias as $media) {
            if (!$useDns || $this->tryDns->tryDns($media->getDnss())) {
                return $media;
            }
        }

        return null;
    }
}