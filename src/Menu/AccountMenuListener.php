<?php


namespace Eres\SyliusReferralMarketingPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AccountMenuListener
{
    public function addAccountMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('referral_marketing', ['route' => 'eres_sylius_referral_marketing_index'])
            ->setLabel('eres_sylius_referral_marketing_plugin.menu.referral_marketing')
            ->setLabelAttribute('icon', 'user');
    }
}
