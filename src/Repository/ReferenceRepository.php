<?php


namespace Workouse\ReferralMarketingPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ReferenceRepository extends EntityRepository
{
    public function countReferences(): int
    {
        return (int)$this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAcceptedReferences(): int
    {
        return (int)$this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.status = :status')
            ->setParameter('status', true)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
