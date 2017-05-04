<?php

namespace Tests\Resources\DataFixtures;

use Alcyon\CoreBundle\Entity\Categorie;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategorie extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        foreach (range(1,2) as $count) {
            $categorie = new Categorie();
            $categorie->setTitle('test categorie');
            $categorie->setCatalogue($this->getReference('catalogue' . $count));
            $manager->persist($categorie);

            $categorieParent = new Categorie();
            $categorieParent->setTitle('Categorie parent');
            $categorieParent->addChild($categorie);
            $categorieParent->setCatalogue($this->getReference('catalogue' . $count));
            $manager->persist($categorieParent);

            $categorieChild = new Categorie();
            $categorieChild->setTitle('Categorie child');
            $categorieChild->addParent($categorie);
            $categorieChild->setCatalogue($this->getReference('catalogue'. $count));
            $manager->persist($categorieChild);

            $manager->flush();
        }
    }
}