<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('workouse_sylius_referral_marketing_plugin');
        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('workouse_sylius_referral_marketing_plugin');
        }

        $rootNode
            ->children()
            ->scalarNode('service')->isRequired()->end()
            ->scalarNode('referrer_promotion_code')->isRequired()->end()
            ->scalarNode('invitee_promotion_code')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
