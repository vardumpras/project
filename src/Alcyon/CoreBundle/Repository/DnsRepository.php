<?php

namespace Alcyon\CoreBundle\Repository;

class DnsRepository extends Repository
{
    public function getDnsByDomaineName($domaineName)
    {
        while ($pos = strpos($domaineName, '.')) {
            $dnsEntity = $this->qbGetDnsWithTheme($domaineName)->getQuery()->getOneOrNullResult();

            if (null != $dnsEntity) {
                return $dnsEntity;
            }

            $domaineName = substr($domaineName, $pos);
        }

        return null;
    }

    public function qbGetDnsWithTheme($dns)
    {
        return $this->createQueryBuilder('d')
            ->join('d.theme', 't')
            ->addSelect('t')
            ->where('d.dns like :dns')
            ->setParameter('dns', $dns);
    }
}
