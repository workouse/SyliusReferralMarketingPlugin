<?php

declare(strict_types=1);

namespace Tests\Workouse\ReferralMarketingPlugin\Behat\Behaviour;

interface ContainsErrorInterface
{
    public function containsErrorWithMessage(string $message, bool $strict = true): bool;
}
