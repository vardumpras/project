<?php

namespace Alcyon\CoreBundle\Repository;

use Alcyon\CoreBundle\Service\GetUrl;

/**
 * MediaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MediaRepository extends Repository
{
    public function findMediaByUrl($url, $start = null, $end = null, $useDns = true)
    {
        return $this->qbFindMediaUrl($url, $start, $end, $useDns)->getQuery()->getResult();
    }

    public function qbFindMediaUrl($url, $start = null, $end = null, $useDns = true)
    {
        if (null == $start) {
            $start = new \DateTime();
        }
        if (null == $end) {
            $end = new \DateTime();
        }

        return $this->createQueryBuilder('m')
            ->leftJoin('m.periodes', 'p')
            ->where('m.url like :url')
            ->andWhere('p.start <= :start  OR p.start IS NULL')
            ->andWhere('p.end <= :end OR p.end IS NULL')
            ->setParameters(array('url' => $url,
                'start' => $start,
                'end' => $end));
    }
}
