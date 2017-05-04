<?php

namespace Alcyon\ExempleBundle\Controller;

use Alcyon\CoreBundle\Controller\Controller;
use Alcyon\CoreBundle\Entity\Periode;
use Alcyon\CoreBundle\Entity\Media;
use Alcyon\CoreBundle\Form\MediaType;
use Alcyon\CoreBundle\Form\UploadMediaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/media")
 */
class MediaController extends Controller
{
    /**
     * @Route("/media")   
     */
     public function mediaAction()
    {
        // Create entity
        $media = new Media();
        $media->addPeriode((new Periode())->setStart(new \DateTime()));
        
        // Handle Form
        $mediaHandle = $this->get('alcyon_exemple.form.mediahandle');        
        $form = $mediaHandle->process(MediaType::class, $media);

        // No form, redirect to homepage
        if(null == $form) {
            return $this->redirectToRoute('homepage');
        }
        
        // Send Form to view
        return $this->render('default/core/media.html.twig', 
                        ['form' => $form->createView()]);        
    }
    
    /**
     * @Route("/uploadmedia")
     */
    public function uploadmediaAction()
    {
        // Create entity
        $media = new Media();
        $media->addPeriode((new Periode())->setStart(new \DateTime()));
        $media->setFolder('exemple');
        
        // Handle Form
        $mediaHandle = $this->get('alcyon_exemple.form.mediahandle');
        $form = $mediaHandle->process(UploadMediaType::class, $media);

        // No form, redirect to homepage
        if(null == $form) {
            return $this->redirectToRoute('homepage');
        }
        
        // Send Form to view
        return $this->render('default/core/uploadmedia.html.twig', 
                        ['form' => $form->createView()]);    
    }
    
}
