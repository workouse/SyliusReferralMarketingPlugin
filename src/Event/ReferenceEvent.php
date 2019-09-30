<?php


namespace Eres\SyliusReferralMarketingPlugin\Event;

use Eres\SyliusReferralMarketingPlugin\Entity\Reference;
use Symfony\Contracts\EventDispatcher\Event;

class ReferenceEvent extends Event
{
    public const NAME = 'reference.post';

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
