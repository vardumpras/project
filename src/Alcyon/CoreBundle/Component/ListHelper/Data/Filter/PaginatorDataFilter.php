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
use Alcyon\CoreBundle\Component\ListHelper\Exception;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaginatorDataFilter extends AbstractDataFilter
{
    private $page;
    private $itemPerPage;

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getItemPerPage()
    {
        return $this->itemPerPage;
    }

    /**
     * @param mixed $itemPerPage
     */
    public function setItemPerPage($itemPerPage)
    {
        $this->itemPerPage = $itemPerPage;
    }

}