<?php

namespace Alcyon\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\MappedSuperclass;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Table(indexes={@ORM\Index(columns={"template"}),
 *                     @ORM\Index(columns={"deletedAt"})})
 * @ORM\Entity(repositoryClass="Alcyon\CoreBundle\Repository\ThemeRepository")
 */
class Theme extends Entity implements
    MappedSuperclass\AuthorInterface,
    MappedSuperclass\SoftDeleteInterface
{
    use MappedSuperclass\Author,
        MappedSuperclass\SoftDelete;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=50)
     */
    private $template;

    /**
     * Set template
     *
     * @param string $template
     *
     * @return Theme
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
