<?php

namespace Tests\Resources\DataFixtures;

use Alcyon\CoreBundle\Entity\Theme;
use Alcyon\CoreBundle\Entity\Dns;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadThemeAndDns extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $theme = new Theme();
        $theme->setTemplate('default');
        $this->addReference('default theme', $theme);
        $manager->persist($theme);

        $theme1 = new Theme();

        $theme1->setTemplate('theme test');
        $manager->persist($theme1);
        $this->addReference('theme1', $theme1);

        $dns = new Dns();
        $dns->setDns('dsn.test.com');
        $dns->setTheme($this->getReference('theme1'));
        $manager->persist($dns);
        $this->addReference('dns', $dns);

        $manager->flush();
    }
}