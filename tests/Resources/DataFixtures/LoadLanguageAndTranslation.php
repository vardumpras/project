<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 24/04/2017
 * Time: 17:32
 */

namespace Tests\Resources\DataFixtures;


use Alcyon\CoreBundle\Entity\Language;
use Alcyon\CoreBundle\Entity\Translation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLanguageAndTranslation  extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $language = new Language();
        $language->setLanguage('fr');
        $language->setTitle('Français');
        $manager->persist($language);

        $this->addReference('language', $language);

        $words = array('Home'      => 'Accueil',
                        'Test'=> 'Test',
                        'One'  => 'Un');

        foreach ($words as $key => $word) {
            $translation = new Translation();
            $translation->setLanguage($language);
            $translation->setKeyTrans($key);
            $translation->setData($word);
            $manager->persist($translation);
        }

        $manager->flush();
    }
}