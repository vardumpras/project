<?php

namespace Alcyon\ExempleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Alcyon\CoreBundle\Entity\Language;

class LoadLanguage extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $languageFr = new Language();
        $languageFr->setLanguage('fr');
        $languageFr->setTitle('Français');
        $manager->persist($languageFr);

        $manager->flush();

        $this->addReference('language_fr', $languageFr);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}