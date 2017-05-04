<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Component\Menu\CreateMenuInterface;
use Alcyon\CoreBundle\Component\Menu\MenuItem;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** 
 * @ORM\MappedSuperclass
 * @ORM\Table(indexes={@ORM\Index(columns={"title"}),
 *                     @ORM\Index(columns={"url"}),
 *                     @ORM\Index(columns={"ordre"})})
 * @ORM\HasLifecycleCallbacks 
 */
abstract class BaseCMS extends Slug implements
    OrdreInterface,
    DefaultImageInterface,
    CreateMenuInterface
{
    use Ordre,
        DefaultImage;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message="title_not_blank")     
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="shortContent", type="string", length=2048, nullable=true)
     */
    private $shortContent;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return BaseCMS
     */
    public function setTitle($title)
    {
        $this->title = ucfirst(substr($title,0,255));

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

    /**
     * Set url
     *
     * @param string $url
     *
     * @return BaseCMS
     */
    public function setUrl($url)
    {
        $this->url = strtolower(substr($url,0,255));

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return BaseCMS
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set shortContent
     *
     * @param string $shortContent
     *
     * @return BaseCMS
     */
    public function setShortContent($shortContent)
    {
        $this->shortContent = substr($shortContent,0,2048);

        return $this;
    }

    /**
     * Get shortContent
     *
     * @return string
     */
    public function getShortContent()
    {
        return $this->shortContent;
    }

    public function createMenuItem() : MenuItem
    {
        $menu = new MenuItem();

        $menu->setTitle($this->getTitle());
        $menu->setUrl($this->getUrl());
        $menu->setVisible(true);

        return $menu;
    }
}
