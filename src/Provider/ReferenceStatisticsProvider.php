<?php


namespace Workouse\ReferralMarketingPlugin\Provider;

use Workouse\ReferralMarketingPlugin\Repository\ReferenceRepository;

class ReferenceStatisticsProvider
{
    /** @var ReferenceRepository */
    private $referenceRepository;

    public function __construct(ReferenceRepository $referenceRepository)
    {
        $this->referenceRepository = $referenceRepository;
    }

    public function getStatistics(): ReferenceStatistics
    {
        return new ReferenceStatistics(
            $this->referenceRepository->countReferences(),
            $this->referenceRepository->countAcceptedReferences(),
            $this->referenceRepository->countReferences() - $this->referenceRepository->countAcceptedReferences()
        );
    }
}
