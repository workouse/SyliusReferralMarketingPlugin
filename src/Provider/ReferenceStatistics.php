<?php

declare(strict_types=1);

namespace Workouse\ReferralMarketingPlugin\Provider;

class ReferenceStatistics
{
    /** @var int */
    private $numberOfTotalReferences;

    /** @var int */
    private $numberOfAcceptedReferences;

    /** @var int */
    private $numberOfRejectedReferences;

    /** @var int */
    private $numberOfRegisterAfterReceivingAnReferences;

    public function __construct(int $numberOfTotalReferences, int $numberOfAcceptedReferences, int $numberOfRejectedReferences, int $numberOfRegisterAfterReceivingAnReferences)
    {
        $this->numberOfTotalReferences = $numberOfTotalReferences;
        $this->numberOfAcceptedReferences = $numberOfAcceptedReferences;
        $this->numberOfRejectedReferences = $numberOfRejectedReferences;
        $this->numberOfRegisterAfterReceivingAnReferences = $numberOfRegisterAfterReceivingAnReferences;
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

    public function getNumberOfRegisterAfterReceivingAnReferences(): int
    {
        return $this->numberOfRegisterAfterReceivingAnReferences;
    }
}
