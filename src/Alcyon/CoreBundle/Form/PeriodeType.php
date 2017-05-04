<?php

namespace Alcyon\CoreBundle\Form;

use Alcyon\CoreBundle\Entity\Periode;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class PeriodeType extends Form
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('start', Type\DateTimeType::class,[
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'readonly' => 'readonly',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd-mm-yyyy',
                        'placeholder' => 'placeholder_date_start',
                        'data-date-week-start' => '1',
                        'data-date-language' => 'fr']
                        ])
          ->add('end', Type\DateTimeType::class, [
                    'required' => false,
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'readonly' => 'readonly',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd-mm-yyyy',
                        'placeholder' => 'placeholder_date_end',
                        'data-date-week-start' => '1',
                        'data-date-language' => 'fr']
                ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Periode::class,
            'cascade_validation' => true)
        );
    }
}
