<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 24/04/2017
 * Time: 15:30
 */

namespace Tests\Resources\DataFixtures;

use Alcyon\CoreBundle\Entity\Catalogue;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCatalogue extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        foreach (range(1,2) as $count) {
            $catalogue = new Catalogue();
            $catalogue->setTitle('test catalogue');
            $this->addReference('catalogue'.$count, $catalogue);
            $manager->persist($catalogue);

            $manager->flush();
        }
    }
}