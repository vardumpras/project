<?php

namespace Alcyon\CoreBundle\EventListener\ORM;

use Alcyon\CoreBundle\Entity\MappedSuperclass\Slug;
use Alcyon\CoreBundle\EventListener\EventListener;
use Alcyon\CoreBundle\Service\Slugify;
use Doctrine\ORM\Event\LifecycleEventArgs;

class SlugListener extends EventListener
{
    private $slugify;

    /**
     * @return Slugify
     */
    public function getSlugify(): Slugify
    {
        return $this->slugify;
    }

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->slugifyTitle($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->slugifyTitle($entity);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->slugifyTitle($entity);
    }

    private function slugifyTitle($entity)
    {
        // force  only works for Slug entities
        if(!$entity instanceof Slug ) {
            return;
        }

        // Get original title
        $title = $entity->getTitle();

        // Slug title
        $slug = $this->slugify->slugify($title);
        $entity->setSlug($slug);
    }
}