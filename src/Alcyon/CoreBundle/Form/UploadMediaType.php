<?php

namespace Alcyon\CoreBundle\Form;

use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class UploadMediaType extends MediaType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', Type\FileType::class, [
                    'required' => false,
                    'label' => 'File',
                    'attr' => [
                        'class' => 'form-control input-inline'
                    ]
                ]
            );

        parent::buildForm($builder, $options);

        $builder->get('url')->setRequired(false);
    }
}
