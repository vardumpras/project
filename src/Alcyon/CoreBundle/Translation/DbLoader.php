<?php

namespace Alcyon\CoreBundle\Translation;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

class DbLoader implements LoaderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    public function __construct(EntityManagerInterface $em) // this is @service_container
    {
        $this->em = $em;
    }

    public function load($resource, $locale, $domain = 'messages')
    {
        $messages = array();

        $transaltionRepository = $this->em->getRepository('AlcyonCoreBundle:Translation');
        $translations = $transaltionRepository->getTranslations($locale);

        foreach ($translations as $translation) {
            $messages[$translation->getKeyTrans()] = $translation->getData();
        }

        $catalogue = new MessageCatalogue($locale);
        $catalogue->add($messages, $domain);

        return $catalogue;
    }

}