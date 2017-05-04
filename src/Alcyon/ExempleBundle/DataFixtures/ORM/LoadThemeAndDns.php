<?php

namespace Alcyon\ExempleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Alcyon\CoreBundle\Entity\Theme;
use Alcyon\CoreBundle\Entity\Dns;

class LoadThemeAndDns extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $theme1 = new Theme();

        $theme1->setTemplate('alcyon');
        $manager->persist($theme1);
       
        $theme2 = new Theme();
        $theme2->setTemplate('chezmonveto');
        $manager->persist($theme2);

        $theme3 = new Theme();
        $theme3->setTemplate('boutique/template1');
        $manager->persist($theme3);

        $theme4 = new Theme();
        $theme4->setTemplate('jdlia');
        $manager->persist($theme4);
        
        $theme5 = new Theme();
        $theme5->setTemplate('default');
        $manager->persist($theme5);
       

        $this->addReference('theme1', $theme1);
        $this->addReference('theme2', $theme2);
        $this->addReference('theme3', $theme3);
        $this->addReference('theme4', $theme4);
        $this->addReference('theme5', $theme5);


        $dns1 = new Dns();
        $dns1->setDns('alcyon.com');
        $dns1->setTheme($this->getReference('theme1'));
        $manager->persist($dns1);
       
        $dns2 = new Dns();
        $dns2->setDns('chezmonveto.com');
        $dns2->setTheme($this->getReference('theme2'));
        $manager->persist($dns2);

        $dns3 = new Dns();
        $dns3->setDns('boutiquetest.com');
        $dns3->setTheme($this->getReference('theme3'));
        $manager->persist($dns3);

        $dns4 = new Dns();
        $dns4->setDns('jdlia.fr');
        $dns4->setTheme($this->getReference('theme4'));
        $manager->persist($dns4);

        $dns5 = new Dns();
        $dns5->setDns('default.com');
        $dns5->setTheme($this->getReference('theme5'));
        $manager->persist($dns5);

        $this->addReference('dns1', $dns1);
        $this->addReference('dns2', $dns2);
        $this->addReference('dns3', $dns3);
        $this->addReference('dns4', $dns4);
        $this->addReference('dns5', $dns5);


        $manager->flush();
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}