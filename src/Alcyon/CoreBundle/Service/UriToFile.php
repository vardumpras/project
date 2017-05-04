<?php

namespace Alcyon\CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UriToFile
{
    /**
     * @var \Alcyon\CoreBundle\Service\Media
     */
    protected $mediaService;

    /**
     * @var string
     */
    protected $uploadPath;

    /**
     * @var string
     */
    protected $webPath;

    /**
     * @return Media
     */
    public function getMediaService(): Media
    {
        return $this->mediaService;
    }

    /**
     * @return string
     */
    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return $this->webPath;
    }

    /**
     * UrlToFile constructor.
     * @param Media $mediaService
     * @param string $uploadPath
     * @param string $webPath
     */
    public function __construct(Media $mediaService, $uploadPath, $webPath)
    {
        $this->mediaService = $mediaService;
        $this->uploadPath = $uploadPath;
        $this->webPath = $webPath;
    }


    /**
     * UrlToFile constructor.
     *
     * @param Media $mediaService
     * @param string $url
     * @param bool $useDns |default = true
     *
     * @return File|NotFoundHttpException
     */
    public function find($url, $useDns = true)
    {
        $media = $this->mediaService->getMedia($url, $useDns);

        if (null !== $media  && $media->getFile() instanceof File) {
            $file = $media->getFile();
        } else if (is_file($this->uploadPath . $url)) {
            $file = new File($this->uploadPath . $url);
        } else if (is_file($this->webPath . 'img/' . $url)) {
            $file = new File($this->webPath . 'img/' . $url);
        } else {
                throw new NotFoundHttpException('file_not_found');
        }

        return $file;
    }
}