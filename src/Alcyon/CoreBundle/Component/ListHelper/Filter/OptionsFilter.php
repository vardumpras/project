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

use Alcyon\CoreBundle\Component\ListHelper\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;


class OptionsFilter extends NumericalFilter
{

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        // Set default type        
        $resolver->setDefaults([
            'type' => Type\ChoiceType::class,
            'type_options' => ['choices' => null]
        ]);

        $resolver
            ->setNormalizer('type_options', function (Options $options, $type_options) {
                if (!is_array($type_options)
                    || !isset($type_options['choices'])
                    || !is_array($type_options['choices'])
                )

                    throw new UnexpectedTypeException($type_options, ' ["choices"]');

                return $type_options;
            });

    }
}

