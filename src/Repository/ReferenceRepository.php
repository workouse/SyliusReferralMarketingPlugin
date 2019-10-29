<?php

declare(strict_types=1);

namespace Workouse\ReferralMarketingPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ReferenceRepository extends EntityRepository
{
    public function countReferences(): int
    {
        return (int) $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAcceptedReferences(): int
    {
        return (int) $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->where('o.status = :status')
            ->setParameter('status', true)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countRegisterAfterReceivingAnReferences(): int
    {
        return (int) $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->innerJoin('Sylius\Component\Customer\Model\Customer', 'c', 'WITH', 'r.referrer = c.id')
            ->innerJoin('Sylius\Component\Core\Model\ShopUser', 'u', 'WITH', 'c.id = u.customer')
            ->getQuery()
            ->getResult();
    }
}
