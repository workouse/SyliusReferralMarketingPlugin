<?php


namespace Workouse\ReferralMarketingPlugin\Service;

use Sylius\Component\Customer\Model\Customer;
use Workouse\ReferralMarketingPlugin\Entity\Reference;

interface PromotionInterface
{
    public function referrerExecute(Reference $reference);

    public function inviteeExecute(Reference $reference);

    public function inviteeUserAfterExecute(Customer $reference);
}
