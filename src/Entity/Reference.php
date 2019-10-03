<?php


namespace Workouse\ReferralMarketingPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Workouse\ReferralMarketingPlugin\Validator\Constraints\UniqueReferrer;

/**
 * @ORM\Entity()
 * @ORM\Table(name="workouse_referral_marketing_reference")
 * @UniqueEntity(
 *     fields={"invitee", "referrerEmail"},
 *     errorPath="referrerEmail"
 * )
 * @UniqueReferrer()
 */
class Reference
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
     * @ORM\Column(type="string")
     */
    protected $referrerName;

    /**
     * @ORM\Column(type="string")
     */
    protected $referrerEmail;

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

    public function getReferrerName()
    {
        return $this->referrerName;
    }

    public function setReferrerName($referrerName): void
    {
        $this->referrerName = $referrerName;
    }

    public function getReferrerEmail()
    {
        return $this->referrerEmail;
    }

    public function setReferrerEmail($referrerEmail): void
    {
        $this->referrerEmail = $referrerEmail;
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
