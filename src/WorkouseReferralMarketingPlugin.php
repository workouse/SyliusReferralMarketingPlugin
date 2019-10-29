<?php

declare(strict_types=1);

namespace Workouse\ReferralMarketingPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Workouse\ReferralMarketingPlugin\DependencyInjection\WorkouseReferralMarketingPluginExtension;

final class WorkouseReferralMarketingPlugin extends Bundle
{
    use SyliusPluginTrait;

    protected function getContainerExtensionClass(): string
    {
        return WorkouseReferralMarketingPluginExtension::class;
    }
}
