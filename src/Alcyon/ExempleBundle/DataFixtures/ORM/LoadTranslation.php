<?php

namespace Alcyon\ExempleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Alcyon\CoreBundle\Entity\Translation;

class LoadTranslation extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $translationArrayFr = array('Home'      => 'Accueil',
                                    'Your plant'=> 'Votre centrale',
                                    'Services'  => 'Les services',
                                    'Institutions' => 'Les établissements',
                                    'International' => 'International',
                                    'Offers'    => 'Petites annonces',
                                    'Search'    => 'Rechercher',
                                    'Thing'     => 'Truc',
                                    'Login'     => 'Se Connecter',
                                    'Logout'    => 'Se Deconnecter',
                                    'Profil'    => 'Profil',
                                    'hi we are monday morning' => 'Bonjour, nous sommes lundi matin',
                                    'Price'     => 'Prix',
                                    'Weight'    => 'poids',
                                    'Quantity'  => 'Quantitée',
                                    'Categories'=> 'Categories',
                                    'Content'   => 'Contenu',
                                    'Send'      => 'Envoyer',
                                    'start'     => 'début',
                                    'Start'     => 'Début',
                                    'end'       => 'fin',
                                    'End'       => 'Fin',
                                    'Periode'   => 'Période',
                                    'placeholder_date_start' => 'Date de début',
                                    'placeholder_date_end' => 'Date de fin',
                                    'add_periode' => 'Ajouter une période',
                                    'date_start_or_end_required' => 'Une date de début ou de fin valide est obligatoire',
                                    'Title'     => 'Titre',
                                    'Url'       => 'Url', 
                                    'Alt'       => 'Alt',    
                                    'File'      => 'Fichier',
                                    'media_save' => 'Le média a été sauvegardé avec succes',
                                    );

        $translationArray = ['language_fr'=>$translationArrayFr];

        foreach ($translationArray as $language => $words) {
            foreach ($words as $key => $word) {

                $translation = new Translation();
                $translation->setLanguage($this->getReference($language));
                $translation->setKeyTrans($key);
                $translation->setData($word);
                $manager->persist($translation);
            }
        }

        $manager->flush();
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}