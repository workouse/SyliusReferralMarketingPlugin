<?php


namespace Workouse\ReferralMarketingPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $newSubmenu = $menu
            ->addChild('index')
            ->setLabel('workouse_referral_marketing_plugin.ui.referral_marketing');
        $newSubmenu
            ->addChild('index', ['route' => 'workouse_referral_marketing_admin_dashboard'])
            ->setLabel('workouse_referral_marketing_plugin.ui.dashboard')
            ->setLabelAttribute('icon', 'star');
    }
}
