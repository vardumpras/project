<?php

namespace Alcyon\ExempleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\MappedSuperclass;

/**
 * AttributType
 *
 * @ORM\Table(name="attribut_type")
 * @ORM\Entity(repositoryClass="Alcyon\ExempleBundle\Repository\AttributTypeRepository")
 */
class AttributType extends MappedSuperclass\BaseCMS
{

}
