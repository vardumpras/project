<?php

namespace Alcyon\ExempleBundle\Entity;

use Alcyon\CoreBundle\Entity\Entity;
use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Table(indexes={@ORM\Index(name="title", columns={"title"})})
 * @ORM\Entity(repositoryClass="Alcyon\ExempleBundle\Repository\TagRepository")
 */
class Tag extends Entity implements MappedSuperclass\AuthorInterface
{
    use MappedSuperclass\Author;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return BaseCMS
     */
    public function setTitle($title)
    {
        $this->title = ucfirst($title);

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
