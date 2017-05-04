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

use Alcyon\CoreBundle\Component\ListHelper\Data\Filter as DataFilter;
use Alcyon\CoreBundle\Component\ListHelper\Transformer;
use Alcyon\CoreBundle\Component\ListHelper\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateFilter extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        // Set default        
        $resolver->setDefaults([
            'type' => Type\DateType::class,
            'transformer'=> Transformer\DateTransformer::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDataFilters()
    {
        // Create start filter
        $dataFilterStart = new DataFilter\ComparisonDataFilter();
        $dataFilterStart->setCondition('lte');
        $dataFilterStart->setField(($this->getOptions())['field']);

        // Get data from type
        $start = $this->getType() ? $this->getType()->get('start')->getData() : null;
        // Transform data from transformer
        $start = $this->getTransformer() && $start? $this->getTransformer()->transform($start) : $start;
        // Set value
        $dataFilterStart->setValue($start);
        
        // Create end filter        
        $dataFilterEnd = new DataFilter\ComparisonDataFilter();
        $dataFilterEnd->setCondition('gte');
        $dataFilterEnd->setField(($this->getOptions())['field']);        
        // Get data from type
        $end = $this->getType() ? $this->getType()->get('end')->getData() : null;
        // Transform data from transformer
        $end = $this->getTransformer() && $end? $this->getTransformer()->transform($end) : $end;
        // Set value
        $dataFilterEnd->setValue($start);

        // return response
        return [$dataFilterStart, $dataFilterEnd];
    }
}
