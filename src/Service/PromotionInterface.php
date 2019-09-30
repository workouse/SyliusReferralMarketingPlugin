<?php


namespace Eres\SyliusReferralMarketingPlugin\Service;

use Eres\SyliusReferralMarketingPlugin\Entity\Reference;

interface PromotionInterface
{
    public function execute(Reference $reference);
}
