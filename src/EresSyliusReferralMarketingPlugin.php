<?php

declare(strict_types=1);

namespace Eres\SyliusReferralMarketingPlugin;

use Eres\SyliusReferralMarketingPlugin\DependencyInjection\EresSyliusReferralMarketingPluginExtension;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class EresSyliusReferralMarketingPlugin extends Bundle
{
    use SyliusPluginTrait;

    protected function getContainerExtensionClass(): string
    {
        return EresSyliusReferralMarketingPluginExtension::class;
    }
}
