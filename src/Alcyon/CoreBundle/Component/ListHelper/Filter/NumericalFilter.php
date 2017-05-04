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


use Alcyon\CoreBundle\Component\ListHelper\Data\Filter\ComparisonDataFilter;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NumericalFilter extends TextFilter
{

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        // disable transformer
        $resolver->setDefaults([
            'transformer' => null
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDataFilters()
    {
        // Use parent to create datafiler
        $arrayDataFiler = parent::getDataFilters();

        // Force Equality comparaison
        foreach ($arrayDataFiler as $dataFilter) {
            $dataFilter->setCondition('eq');
        }

        return $arrayDataFiler;
    }
}
