<?php

declare(strict_types=1);

namespace Tests\Workouse\SyliusReferralMarketingPlugin\Behat\Page\Shop;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Tests\Workouse\SyliusReferralMarketingPlugin\Behat\Behaviour\ContainsErrorTrait;

class ReferenceCheckPage extends SymfonyPage
{
    use ContainsErrorTrait;

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'workouse_referral_marketing_check';
    }
}
