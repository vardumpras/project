<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 07/03/2017
 * Time: 13:18
 */

namespace Alcyon\CoreBundle\Service;

interface SlugifyProviderInterface
{
    /**
     * Return an array of key=> rule
     *
     * @return array
     */
    public function getRules();
}