<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alcyon\CoreBundle\Component\ListHelper\Type;

use Alcyon\CoreBundle\Component\ListHelper\Exception\InvalidArgumentException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaginationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentpage', Type\HiddenType::class, ['data' => $options['currentpage']])
            ->add('itemperpage', Type\ChoiceType::class, ['choices' => $options['itemperpage'], 'data' => $options['data_itemperpage']])
            ->add('nbpaginationitem', Type\HiddenType::class, ['data' => $options['nbpaginationitem']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // Set default        
        $resolver->setRequired(['currentpage', 'itemperpage', 'data_itemperpage', 'nbpaginationitem']);

        $resolver->setAllowedTypes('currentpage', 'int')
            ->setAllowedTypes('itemperpage', ['int', 'array'])
            ->setAllowedTypes('data_itemperpage', 'int')
            ->setAllowedTypes('nbpaginationitem', 'int');

        $resolver->setNormalizer('itemperpage', function(Options $option, $itemperpage) {

            if(is_int($itemperpage))
                $itemperpage = [$itemperpage];

            if(0 == count($itemperpage))
                throw new InvalidArgumentException($itemperpage, 'array of int');

            
            // Verify all tags are string => string
            foreach($itemperpage as $key => $value) {
                if(!is_int($key) || !is_int($value))
                    throw new InvalidArgumentException($itemperpage, 'array of int');
            }

            return $itemperpage;
        })->setNormalizer('data_itemperpage', function(Options $option, $data_itemperpage) {

            if(!in_array($data_itemperpage, $option['itemperpage']))
                $data_itemperpage = $option['itemperpage'][0];

            return $data_itemperpage;
        });
    }
}