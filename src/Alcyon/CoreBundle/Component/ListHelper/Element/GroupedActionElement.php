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

use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupedActionElement extends FooterElement
{
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        // Set default
        $resolver->setDefaults([
                            'auto_check_all' => false,
                            'auto_uncheck_all' => false,
                            'tags' => ['grouped-action', 'footer'],
                            'path' => '',
                            ]);  


        // Set allowed values
        $resolver->setAllowedValues('auto_check_all', [true, false])
                 ->setAllowedValues('auto_uncheck_all', [true, false]);            
    }
}
