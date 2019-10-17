<?php


namespace Workouse\ReferralMarketingPlugin\Event;

use Workouse\ReferralMarketingPlugin\Entity\Reference;
use Symfony\Contracts\EventDispatcher\Event;

class ReferenceEvent extends Event
{
    public const REFERRER_POST = 'referrer.post';
    public const INVITEE_POST = 'invitee.post';

    protected $reference;

    public function __construct(Reference $reference)
    {
        $this->reference = $reference;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
