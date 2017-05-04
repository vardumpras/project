<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Alcyon\CoreBundle\Component\ListHelper\Filter;

use Alcyon\CoreBundle\Component\ListHelper\Data\Filter\PaginatorDataFilter;
use Alcyon\CoreBundle\Component\ListHelper\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaginationFilter extends AbstractFilter
{
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        // Set default
        $resolver   ->setDefaults([
                    'type'              => Type\PaginationType::class,
                    'type_options'      => ['currentpage' =>1,
                                            'itemperpage' => [20, 50, 100],
                                            'data_itemperpage' => 20,
                                            'nbpaginationitem' => 5],
                ])
        ;
    } 
	/**
     * {@inheritdoc}
     */
    public function getDataFilters()
    {
        $dataFilter = new PaginatorDataFilter();

        $form = $this->getType();
        if($form) {
            $dataFilter->setPage($form->get('currentpage')->getData());
            $dataFilter->setItemPerPage($form->get('itemperpage')->getData());
        }

        return [$dataFilter];
    }
}