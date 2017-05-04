<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alcyon\CoreBundle\Component\ListHelper\Element;

use Alcyon\CoreBundle\Component\ListHelper\BuilderInterface;
use Alcyon\CoreBundle\Component\ListHelper\FilterInterface;
use Alcyon\CoreBundle\Component\ListHelper\TransformerInterface;
use Alcyon\CoreBundle\Component\ListHelper\Exception\UnexpectedTypeException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListElement extends BaseElement
{
    /**
     * {@inheritdoc}
     */
    public function buildList(BuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(['filter' => null,
            'transformer' => null,
        ]);

        // Set allowed Types
        $resolver->setAllowedTypes('filter', ['null', 'string', 'array'])
            ->setAllowedTypes('transformer', ['null', 'string', 'array']);


        // Set normalizer
        $resolver->setNormalizer('filter', function (Options $options, $filter) {
            $optionsFilter = [];
            if (is_array($filter)) {
                foreach ($filter as $key => $value) {
                    if (is_string($value) && in_array(FilterInterface::class, class_implements($value))) {
                        $filter = $value;
                    } else {
                        $optionsFilter[$key] = $value;
                    }
                }

                if (is_array($filter))
                    $filter = \Alcyon\CoreBundle\Component\ListHelper\Filter\TextFilter::class;
            }

            if (null !== $filter && !is_string($filter) && !$filter instanceof FilterInterface) {
                throw new UnexpectedTypeException($filter, 'string, array or ' . FilterInterface::class);
            }


            if (!isset($optionsFilter['field']) && null !== $filter) {
                $optionsFilter['field'] = $options['name'];
            }
            if (null !== $filter && !$filter instanceof FilterInterface) {
                $filter = new $filter();
                $filter->setOptions($optionsFilter);
            }

            return $filter;
        })
            ->setNormalizer('transformer', function (Options $options, $transformer) {
                $optionsTransformer = [];
                if (is_array($transformer)) {
                    foreach ($transformer as $key => $value) {
                        if (is_string($value) && in_array(TransformerInterface::class, class_implements($value))) {
                            $transformer = $value;
                        } else {
                            $optionsTransformer[$key] = $value;
                        }
                    }

                    if (is_array($transformer))
                        $transformer = \Alcyon\CoreBundle\Component\ListHelper\Transformer\StringTransformer::class;
                }

                if (null !== $transformer && !is_string($transformer) && !$transformer instanceof TransformerInterface) {

                    throw new UnexpectedTypeException($transformer, 'string, array or ' . TransformerInterface::class);
                }

                if (!isset($optionsTransformer['field']) && null !== $transformer) {
                    $optionsTransformer['field'] = $options['name'];
                }

                if (null !== $transformer && !$transformer instanceof TransformerInterface) {
                    $transformer = new $transformer();
                    $transformer->setOptions($optionsTransformer);
                }

                return $transformer;
            })
            ->setNormalizer('tags', function (Options $options, $tags) {

                // Convert String to array
                if (is_string($tags))
                    $tags = [$tags];

                // Verify all tags are string
                foreach ($tags as $key => $tag) {
                    if (!is_int($key) || !is_string($tag))
                        throw new UnexpectedTypeException($tags, 'array of string');
                }

                return $tags;
            });

        return $this;
    }
}
