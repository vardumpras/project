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

use Alcyon\CoreBundle\Component\ListHelper\FilterInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var Form
     */
    private $type;

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options = [])
    {
        $resolver = new OptionsResolver();
       
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // Set default        
        $resolver->setDefaults([
            'type' => null,
            'type_options' => ['required' => false],
            'transformer' => null,
        ]);

        $resolver->setRequired('field');

        $resolver->setAllowedTypes('field', ['string'])
            ->setAllowedTypes('type', ['null', 'string'])
            ->setAllowedTypes('type_options', 'array')
            ->setAllowedTypes('transformer', ['null', 'array', 'string']);

        $resolver
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
                    $optionsTransformer['field'] = $options['field'];
                }

                if (null !== $transformer && !$transformer instanceof TransformerInterface) {
                    $transformer = new $transformer();
                    $transformer->setOptions($optionsTransformer);
                }

                return $transformer;
            });
    }

    /**
     * Get transformer of this Filter
     *
     * @return TransformerInterface|null
     */
    protected function getTransformer()
    {
        return ($this->getOptions()) ['transformer'];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function addToForm($name, FormInterface $form)
    {
        $options = $this->getOptions();

        if (null !== $options['type']) {
            $form->add($name, $options['type'], $options['type_options']);

            $this->type = $form->get($name);
        }
    }
}