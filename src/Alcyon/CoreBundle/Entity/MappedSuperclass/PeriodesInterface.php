<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 16/03/2017
 * Time: 16:36
 */

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;


interface PeriodesInterface
{
    /**
     * Add periode
     *
     * @param \Alcyon\CoreBundle\Entity\Periode $periode
     *
     * @return mixed
     */
    public function addPeriode(\Alcyon\CoreBundle\Entity\Periode $periode);

    /**
     * Remove periode
     *
     * @param \Alcyon\CoreBundle\Entity\Periode $periode
     *
     * @return mixed
     */
    public function removePeriode(\Alcyon\CoreBundle\Entity\Periode $periode);

    /**
     * Get periodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeriodes();
}