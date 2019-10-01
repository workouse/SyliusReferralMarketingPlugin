<?php


namespace Workouse\ReferralMarketingPlugin\EventSubscriber;

use Workouse\ReferralMarketingPlugin\Event\ReferenceEvent;
use Workouse\ReferralMarketingPlugin\Service\PromotionInterface;

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
