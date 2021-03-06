<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
use Workouse\SyliusReferralMarketingPlugin\Validator\Constraints\UniqueReferrer;

/**
 * @ORM\Entity()
 * @ORM\Table(name="workouse_referral_marketing_reference")
 * @UniqueReferrer()
 */
class Reference implements ResourceInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne("Sylius\Component\Customer\Model\CustomerInterface")
     * @ORM\JoinColumn(name="invitee_id", referencedColumnName="id")
     */
    protected $invitee;

    /**
     * @ORM\ManyToOne("Sylius\Component\Customer\Model\CustomerInterface")
     * @ORM\JoinColumn(name="referrer_id", referencedColumnName="id")
     */
    protected $referrer;

    /**
     * @ORM\Column(type="string")
     */
    protected $referrerName;

    /**
     * @ORM\Column(type="string")
     */
    protected $hash;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $status = false;

    public function getId()
    {
        return $this->id;
    }

    public function getInvitee()
    {
        return $this->invitee;
    }

    public function setInvitee($invitee): void
    {
        $this->invitee = $invitee;
    }

    public function getReferrer()
    {
        return $this->referrer;
    }

    public function setReferrer($referrer): void
    {
        $this->referrer = $referrer;
    }

    public function getReferrerName()
    {
        return $this->referrerName;
    }

    public function setReferrerName($referrerName): void
    {
        $this->referrerName = $referrerName;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }
}
