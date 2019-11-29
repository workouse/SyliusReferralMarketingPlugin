<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\EventSubscriber;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\GenericEvent;
use Workouse\SyliusReferralMarketingPlugin\Event\ReferenceEvent;
use Workouse\SyliusReferralMarketingPlugin\Service\PromotionInterface;

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

    public function completeInviteeAfter(ReferenceEvent $event)
    {
        /** @var PromotionInterface $promotionService */
        $promotionService = $this->container->get($this->serviceName);
        $promotionService->referrerExecute($event->getReference());
    }

    public function completeReferenceAfter(ReferenceEvent $event)
    {
        /** @var PromotionInterface $promotionService */
        $promotionService = $this->container->get($this->serviceName);
        $promotionService->inviteeExecute($event->getReference());
    }

    public function referrerUserRegistration(GenericEvent $event)
    {
        /** @var PromotionInterface $promotionService */
        $promotionService = $this->container->get($this->serviceName);
        $promotionService->inviteeUserAfterExecute($event->getSubject());
    }
}
