<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Alcyon\CoreBundle\Component\ListHelper\Data\Filter;

use Alcyon\CoreBundle\Component\ListHelper\DataFilterInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderDataFilter extends AbstractDataFilter
{
    private $orderBy;

    private $orderWay;

    /**
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param mixed $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return mixed
     */
    public function getOrderWay()
    {
        return $this->orderWay;
    }

    /**
     * @param mixed $orderWay
     */
    public function setOrderWay($orderWay)
    {
        $this->orderWay = $orderWay;
    }
}