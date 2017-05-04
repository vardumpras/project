<?php

namespace Alcyon\ExempleBundle\Form\Handle;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MediaHandle
{
    protected $em;              // entity manager from Doctrine
    protected $formFactory;     // FormFactoryInterfac from form component
    protected $requestStack;    // RequestStack from HttpFoundation
    
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
    }
    
    public function process($formName, $media)
    {
        $request = $this->requestStack->getCurrentRequest();
        
        $form = $this->formFactory->create($formName, $media);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $this->em->persist($media);
            $this->em->flush();

            $request->getSession()
                 ->getFlashBag()
                 ->add('success', 'media_save');

            return null;
        
        }
        
        return $form;
    }
}
