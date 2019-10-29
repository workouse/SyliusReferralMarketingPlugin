<?php

declare(strict_types=1);

namespace Workouse\ReferralMarketingPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AccountMenuListener
{
    public function addAccountMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('referral_marketing', ['route' => 'workouse_referral_marketing_index'])
            ->setLabel('workouse_referral_marketing_plugin.menu.referral_marketing')
            ->setLabelAttribute('icon', 'user');
    }
}
