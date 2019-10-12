<?php

declare(strict_types=1);

namespace Tests\Workouse\ReferralMarketingPlugin\Behat\Page\Shop;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Tests\Workouse\ReferralMarketingPlugin\Behat\Behaviour\ContainsErrorTrait;

class ReferenceIndexPage extends SymfonyPage
{
    use ContainsErrorTrait;

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'workouse_referral_marketing_index';
    }

    public function getStatus()
    {
        return $this->getElement('ReferralStatus')->getText();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'ReferralStatus' => 'span.label',
        ]);
    }

}
