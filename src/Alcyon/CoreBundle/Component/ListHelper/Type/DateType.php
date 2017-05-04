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

class DateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('start', Type\DateType::class,[
                    'required' => false,
                    'data' => $options['start'],
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'placeholder' => 'placeholder_date_start',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd-mm-yyyy',
                        'data-date-autoclose' => 'true',
                        'data-date-week-start' => '1',
                        'data-date-language' => 'fr']
                        ])
          ->add('end', Type\DateType::class, [
                    'required' => false,
                    'data' => $options['end'],
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'placeholder' => 'placeholder_date_end',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd-mm-yyyy',
                        'data-date-autoclose' => 'true',
                        'data-date-week-start' => '1',
                        'data-date-language' => 'fr']
                ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['start' => null,
                               'end' => null]);
                               
        $resolver->setAllowedTypes('start', ['null', 'int'])
                ->setAllowedTypes('end', ['null', 'int']);
    }
}