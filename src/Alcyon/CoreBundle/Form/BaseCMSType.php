<?php

namespace Alcyon\CoreBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

abstract class BaseCMSType extends Form
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            ->add('content')
            ->add('shortContent') 
            ->add('ordre')
            ->add('defaultImage')
        ;
    }
}
