<?php

namespace Alcyon\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Periode
 *
 * @ORM\Table(name="periode")
 * @ORM\Table(indexes={@ORM\Index(columns={"start"}),
 *                     @ORM\Index(columns={"end"})})
 * @ORM\Entity(repositoryClass="Alcyon\CoreBundle\Repository\PeriodeRepository")
 */
class Periode extends Entity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Periode
     */
    public function setStart(\DateTime $start = null)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Periode
     */
    public function setEnd(\DateTime $end = null)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @Assert\Callback()
     */
    public function validate(ExecutionContextInterface $context)
    {
        $start  = $this->getStart();
        $end    = $this->getEnd();

        // If $start = null, or $end ==null, but not $start and $end at same time
        if(null == $start xor null == $end) {
            return;
        }

        // Start and End null
        if(null == $start && null == $end) {
            $context->buildViolation('date_start_or_end_required')
                ->atPath('start')
                ->addViolation();

            return;
        }

        // test if Start < Eend
        if( $start->getTimestamp() > $end->getTimestamp()){

            $context->buildViolation('date_start_or_end_required')
                ->atPath('start')
                ->addViolation();

            return;
        }
    }
}
