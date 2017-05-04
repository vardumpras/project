<?php

namespace Alcyon\CoreBundle\Form;

use Alcyon\CoreBundle\Entity\Media;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints\Valid;

class MediaType extends Form
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    	  ->add('url', Type\TextType::class,[
                'required' => true,
    	  		'attr' => [
    	  			'class' => 'form-control input-inline']])
    	  ->add('title', Type\TextType::class,[
    	  		'attr' => [
    	  			'class' => 'form-control input-inline']])
    	  ->add('alt', Type\TextType::class,[
    	  		'required' => false,
    	  		'attr' => [
                    'class' => 'form-control input-inline']])
    	  // Partie imbriqué Periode
    	  ->add('periodes', Type\CollectionType::class, [
		        'entry_type'   => PeriodeType::class,
                'error_bubbling' => false,
		        'allow_add'    => true,
		        'allow_delete' => true
                ])
    	  ->add('send', Type\SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Media::class,
            'cascade_validation' => true)
        );
    }
}
