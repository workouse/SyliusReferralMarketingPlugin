<?php

declare(strict_types=1);

namespace Workouse\ReferralMarketingPlugin\EventSubscriber;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\GenericEvent;
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

    public function completeInviteeAfter(ReferenceEvent $event)
    {
        $this->container->get($this->serviceName)->referrerExecute($event->getReference());
    }

    public function completeReferenceAfter(ReferenceEvent $event)
    {
        $this->container->get($this->serviceName)->inviteeExecute($event->getReference());
    }

    public function referrerUserRegistration(GenericEvent $event)
    {
        $this->container->get($this->serviceName)->inviteeUserAfterExecute($event->getSubject());
    }
}
