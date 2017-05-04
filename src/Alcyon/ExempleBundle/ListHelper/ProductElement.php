<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alcyon\ExempleBundle\ListHelper;

use Alcyon\CoreBundle\Component\ListHelper\BuilderInterface;
use Alcyon\CoreBundle\Component\ListHelper\Element;
use Alcyon\CoreBundle\Component\ListHelper\Filter;

class ProductElement extends Element\AbstractElement
{
    /**
     * {@inheritdoc}
     */
    public function buildList(BuilderInterface $builder, array $options)
    {

        // Header action
        $builder->add('add',
            Element\HeaderActionElement::class,
            ['class' => 'glyphicon glyphicon-plus-sign',
                'path' => 'addproduct'])
            // Field
            ->add('id', null, ['filter' => Filter\NumericalFilter::class, 'attr' => ['class' => 'text-center']])
            ->add('title')
            ->add('reference', null, ['attr' => ['class' => 'text-center']])
            ->add('content', null, ['transformer' => ['max_length' => 100], 'class' => 'nowrap'])
            ->add('url')
            ->add('ordre', null, [
                'attr' => ['class' => 'text-right'],
                'filter' => [
                    Filter\OptionsFilter::class,
                    'type_options' => [
                        'choices' => ['' => '', '0' => '0', '1' => '1', '2' => '2'],
                        'required' => false]
                ]
            ])
            // Inline action
            ->add('edit',
                Element\InlineActionElement::class,
                ['class' => 'glyphicon glyphicon-pencil',
                    'path' => 'editproduct'
                ])
            ->add('duplicate',
                Element\InlineActionElement::class,
                ['class' => 'glyphicon glyphicon-duplicate',
                    'path' => 'duplicateproduct'
                ])
            ->add('delete',
                Element\InlineActionElement::class,
                ['class' => 'glyphicon glyphicon-trash',
                    'attr' => ['class' => 'delete'],
                    'path' => 'deleteproduct'
                ])
            // Grouped action
            ->add('select_all',
                Element\GroupedActionElement::class,
                ['class' => 'glyphicon glyphicon-check', 'auto_check_all' => true])
            ->add('unselect_all',
                Element\GroupedActionElement::class,
                ['class' => 'glyphicon glyphicon-unchecked', 'auto_uncheck_all' => true])
            ->add('divider',
                Element\GroupedActionElement::class,
                ['disabled' => true])
            ->add('enable_selection',
                Element\GroupedActionElement::class,
                ['class' => 'glyphicon glyphicon-off text-success'])
            ->add('disable_selection',
                Element\GroupedActionElement::class,
                ['class' => 'glyphicon glyphicon-off text-danger'])
            // Pagination
            ->add('pagination',
                Element\PaginationElement::class);
    }
}