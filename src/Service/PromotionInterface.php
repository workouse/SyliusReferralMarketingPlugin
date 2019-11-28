<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\Service;

use Sylius\Component\Customer\Model\Customer;
use Workouse\SyliusReferralMarketingPlugin\Entity\Reference;

interface PromotionInterface
{
    public function referrerExecute(Reference $reference);

    public function inviteeExecute(Reference $reference);

    public function inviteeUserAfterExecute(Customer $reference);
}
