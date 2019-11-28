<?php

declare(strict_types=1);

namespace Tests\Workouse\SyliusReferralMarketingPlugin\Behat\Page\Shop;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Tests\Workouse\SyliusReferralMarketingPlugin\Behat\Behaviour\ContainsErrorTrait;

class ReferenceNewPage extends SymfonyPage
{
    use ContainsErrorTrait;

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'workouse_referral_marketing_new';
    }

    public function fillReferrerName(string $referrerName): void
    {
        $this->getDocument()->fillField('Referrer Name', $referrerName);
    }

    public function fillReferrerEmail(string $referrerEmail): void
    {
        $this->getDocument()->fillField('Referrer Email', $referrerEmail);
    }

    public function create(): void
    {
        $this->getDocument()->pressButton('Add');
    }
}
