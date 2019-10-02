<?php


namespace Workouse\ReferralMarketingPlugin\EventSubscriber;

use Symfony\Component\DependencyInjection\Container;
use Workouse\ReferralMarketingPlugin\Event\ReferenceEvent;
use Workouse\ReferralMarketingPlugin\Service\PromotionInterface;

class ReferenceSubscriber
{
    /** @var Container */
    private $container;

    /** @var PromotionInterface */
    private $serviceName;

    public function __construct(Container $container, $serviceName)
    {
        $this->container = $container;
        $this->serviceName = $serviceName;
    }

    public function completeReferenceAfter(ReferenceEvent $event)
    {
        $this->container->get($this->serviceName)->execute($event->getReference());

    }
}
