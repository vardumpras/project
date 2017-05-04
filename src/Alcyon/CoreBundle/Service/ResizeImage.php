<?php

namespace Alcyon\CoreBundle\Service;

use Psr\Cache\CacheItemPoolInterface;

class ResizeImage
{
    const MaxWidth = 1024;
    const MaxHeight = 1024;

    private $imagePathToResource;
    private $cache;

    public function __construct(ImagePathToResource $imagePathToResource, CacheItemPoolInterface $cache)
    {
        $this->imagePathToResource = $imagePathToResource;
        $this->cache = $cache;
    }

    /**
     * Resize a image and return a Resource of generated image
     *
     * @param $sourceFile       Path of original image
     * @param $w                with of final image
     * @param $h                height of final image
     * @param $destinationFile  Desination folder of final image
     * @param bool $crop Crop image, default false
     *
     * @return Resource|null
     */
    public function resize($sourceFile, int $w, int $h, $destinationFile, $crop = false)
    {
        // Is readable ?
        if (!is_readable($sourceFile))
            return null;

        // Is an image ?
        if (!@is_array(getimagesize($sourceFile))) {
            return null;
        }

        $resizedCacheItem = $this->cache->getItem('resize' . md5($destinationFile) . filemtime($sourceFile));
        if ($dataFile = $resizedCacheItem->get())
            return $dataFile;

        //mkdir if neeeded
        if (!is_dir(dirname($destinationFile)))
            mkdir(dirname($destinationFile));

        if (!is_file($destinationFile) ||
            filemtime($sourceFile) > filemtime($destinationFile)
        ) {  // Cache or file doesnt exist

            // Convert path to resource
            $src = $this->imagePathToResource->getResource($sourceFile);
            if (!$src)
                return null;

            list($width, $height) = getimagesize($sourceFile);

            $r = $width / $height;

            if ($crop) {
                if ($width > $height) {
                    $width = ceil($width-($width*abs($r-$w/$h)));
                } else {
                    $height = ceil($height-($height*abs($r-$w/$h)));
                }
                $newWidth = $w;
                $newHeight = $h;
            } else {
                if ($w/$h > $r) {
                    $newWidth = $h*$r;
                    $newHeight = $h;
                } else {
                    $newHeight = $w/$r;
                    $newWidth = $w;
                }
            }

            if($newWidth > self::MaxWidth)
                $newWidth = self::MaxWidth;

            if($newHeight > self::MaxHeight)
                $newHeight = self::MaxHeight;

            $dst = imagecreatetruecolor($newWidth, $newHeight);
            $background = imagecolorallocate($dst, 255, 255, 255);      // white color
            imagefill($dst, 0, 0, $background);
            imagecopyresampled($dst, $src, ($w - $newWidth) / 2, ($h - $newHeight) / 2, 0, 0, $newWidth, $newHeight, $width, $height);

            // Create image
            imagejpeg($dst, $destinationFile);
        }

        $dataFile = file_get_contents($destinationFile);

        // Save to cache
        $resizedCacheItem->set($dataFile);
        $this->cache->save($resizedCacheItem);
        $this->cache->commit();


        return $dataFile;
    }
}