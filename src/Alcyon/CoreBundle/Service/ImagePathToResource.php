<?php

namespace Alcyon\CoreBundle\Service;

class ImagePathToResource
{
    public function getResource($source)
    {
        if(!@is_array(getimagesize($source))){
            return false;
        }

        $imgType = exif_imagetype($source);

        switch($imgType) {
            case IMAGETYPE_JPEG: return imagecreatefromjpeg($source); break;
            case IMAGETYPE_PNG: return imagecreatefrompng($source); break;
            case IMAGETYPE_GIF: return imagecreatefromgif($source); break;
        }

        return false;
    }
}