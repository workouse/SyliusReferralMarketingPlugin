<?php

declare(strict_types=1);

namespace Workouse\ReferralMarketingPlugin\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Workouse\ReferralMarketingPlugin\Entity\Reference;

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
