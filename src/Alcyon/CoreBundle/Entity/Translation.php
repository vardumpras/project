<?php

namespace Alcyon\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\Entity as BaseEntity;

/**
 * Translation
 *
 * @ORM\Table(name="translation")
 * @ORM\Entity(repositoryClass="Alcyon\CoreBundle\Repository\TranslationRepository")
 */
class Translation extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Alcyon\CoreBundle\Entity\Language", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id", nullable=true, onDelete="set null")
     */    
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="key_trans", type="string", length=50)
     */
    private $keyTrans;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text")
     */
    private $data;

    /**
     * Set keyTrans
     *
     * @param string $keyTrans
     *
     * @return Translation
     */
    public function setKeyTrans($keyTrans)
    {
        $this->keyTrans = $keyTrans;

        return $this;
    }

    /**
     * Get keyTrans
     *
     * @return string
     */
    public function getKeyTrans()
    {
        return $this->keyTrans;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Translation
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set language
     *
     * @param \Alcyon\CoreBundle\Entity\Language $language
     *
     * @return Translation
     */
    public function setLanguage(\Alcyon\CoreBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Alcyon\CoreBundle\Entity\Language|null
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
