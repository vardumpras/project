<?php

namespace Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Table(indexes={@ORM\Index(columns={"deletedAt"})})
 * @ORM\Entity(repositoryClass="Alcyon\CoreBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media extends MappedSuperclass\BaseCMS implements
    MappedSuperclass\AuthorInterface,
    MappedSuperclass\DnssInterface,
    MappedSuperclass\PeriodesInterface,
    MappedSuperclass\SoftDeleteInterface

{
    use MappedSuperclass\Author,
        MappedSuperclass\SoftDelete,
        MappedSuperclass\Periodes,
        MappedSuperclass\Dnss;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=true)
     * @Assert\File()
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=255, nullable=true)
     */
    private $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Media
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get folder
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set folder
     *
     * @param string $folder
     *
     * @return Media
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Media
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }
}
