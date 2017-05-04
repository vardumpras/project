<?php

namespace Alcyon\CoreBundle\Repository;
use Alcyon\CoreBundle\Entity\Language;


/**
 * TranslationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TranslationRepository extends Repository
{
    /**
     * Return all translations for specified token
     *
     * @param type $language
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function qbGetTranslations($language)
    {
        return $this->createQueryBuilder('t')
            ->join('t.language', 'l')
            ->where('l.language like :language')
            ->setParameters(array('language' => $language));

    }
	 /**
      * Return all translations for specified $language
      *
      * @param type $language
      *
      * @return array
     */
    public function getTranslations($language)
    {
		return $this->qbGetTranslations($language)->getQuery()->getResult();
    }

}

