<?php


namespace Eres\SyliusReferralMarketingPlugin\EventSubscriber;

use Eres\SyliusReferralMarketingPlugin\Event\ReferenceEvent;
use Eres\SyliusReferralMarketingPlugin\Service\PromotionInterface;

class ReferenceSubscriber
{
    /** @var PromotionInterface */
    private $promotion;

    public function __construct(PromotionInterface $promotion)
    {
        $this->promotion = $promotion;
    }

    public function completeReferenceAfter(ReferenceEvent $event)
    {
        $this->promotion->execute($event->getReference());

    }
}
