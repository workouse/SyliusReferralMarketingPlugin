<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Workouse\SyliusReferralMarketingPlugin\DependencyInjection\WorkouseSyliusReferralMarketingExtension;

final class WorkouseSyliusReferralMarketingPlugin extends Bundle
{
    use SyliusPluginTrait;

    protected function getContainerExtensionClass(): string
    {
        return WorkouseSyliusReferralMarketingExtension::class;
    }
}
