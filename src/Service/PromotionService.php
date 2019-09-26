<?php


namespace Eres\SyliusReferralMarketingPlugin\Service;

class PromotionService
{
    public function createHash($inviteeEmail, $referrerEmail)
    {
        return sha1(uniqid() . '-' . $inviteeEmail . '-' . $referrerEmail);
    }

}
