<?php
namespace Alcyon\CoreBundle\Service;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

class EnabledFilter extends SQLFilter
{
    private $date = null;

    /**
     * @return \DateTime | null
     */
    public function getDate() : \DateTime
    {
        if(null == $this->date) {
            $this->date = new \DateTime();
        }

        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->hasField("enabledAt")) {
            $date = $this->getDate()->format("Y-m-d H:i:s");

            return $targetTableAlias.".enabledAt <= '".$date."' OR ".$targetTableAlias.".enabledAt IS NULL";
        }

        return "";
    }
}