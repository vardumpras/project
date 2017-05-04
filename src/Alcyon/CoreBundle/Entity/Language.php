<?php

namespace Alcyon\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\MappedSuperclass;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Table(indexes={@ORM\Index(columns={"deletedAt"})})
 * @ORM\Entity(repositoryClass="Alcyon\CoreBundle\Repository\LanguageRepository")
 */
class Language extends MappedSuperclass\BaseCMS implements
    MappedSuperclass\SoftDeleteInterface,
    MappedSuperclass\AuthorInterface
{
    use MappedSuperclass\Author, 
        MappedSuperclass\SoftDelete;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=2)
     */
    private $language;

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Language
     *
     * @throws \LogicException
     */
    public function setLanguage($language)
    {
        if(!is_string($language) || 2 != strlen($language))
            throw new \LogicException('Language must be a string of 2 chars');

        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}

