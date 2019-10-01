<?php


namespace Workouse\ReferralMarketingPlugin\Service;

use Workouse\ReferralMarketingPlugin\Entity\Reference;

interface PromotionInterface
{
    public function execute(Reference $reference);
}
