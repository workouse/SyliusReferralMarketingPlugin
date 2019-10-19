<?php


namespace Workouse\ReferralMarketingPlugin\Provider;


class ReferenceStatistics
{
    /** @var int */
    private $numberOfTotalReferences;

    /** @var int */
    private $numberOfAcceptedReferences;

    /** @var int */
    private $numberOfRejectedReferences;

    public function __construct(int $numberOfTotalReferences, int $numberOfAcceptedReferences, int $numberOfRejectedReferences)
    {
        $this->numberOfTotalReferences = $numberOfTotalReferences;
        $this->numberOfAcceptedReferences = $numberOfAcceptedReferences;
        $this->numberOfRejectedReferences = $numberOfRejectedReferences;
    }

    public function getNumberOfTotalReferences(): int
    {
        return $this->numberOfTotalReferences;
    }

    public function getNumberOfAcceptedReferences(): int
    {
        return $this->numberOfAcceptedReferences;
    }

    public function getNumberOfRejectedReferences(): int
    {
        return $this->numberOfRejectedReferences;
    }
}
