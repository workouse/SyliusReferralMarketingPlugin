<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class WorkouseSyliusReferralMarketingExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yml');

        foreach ($config as $key => $value) {
            $container->setParameter('workouse_referral_marketing.' . $key, $value);
        }
    }

    public function getAlias()
    {
        return 'workouse_sylius_referral_marketing';
    }
}
