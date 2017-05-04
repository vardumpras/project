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
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextFilter extends AbstractFilter
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        // Set default        
        $resolver->setDefaults([
            'type' => Type\TextType::class,
            'transformer'=> Transformer\LikeTransformer::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDataFilters()
    {
        $dataFilter = new DataFilter\ComparisonDataFilter();
        $dataFilter->setCondition('like');
        $dataFilter->setField(($this->getOptions())['field']);

        // Get data from type
        $data = $this->getType() ? $this->getType()->getData() : null;

        // Transform data from transformer
        $data = $this->getTransformer() && $data? $this->getTransformer()->transform($data) : $data;

        $dataFilter->setValue($data);

        return [$dataFilter];
    }
}
