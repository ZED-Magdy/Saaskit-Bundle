<?php
namespace ZedMagdy\Bundle\SaasKitBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('saas_kit');

        $treeBuilder->getRootNode()
            ->children()
            ->enumNode('identifier')
                ->defaultValue('prefix')
                ->values([
                    'prefix',
                    'slash'
                ])
                ->cannotBeEmpty()
                ->info("prefix: tenant.example.com\nslash: example.com/tenant")
            ->end()
            ->scalarNode('tenants_files_path')
            ->defaultValue('%kernel.project_dir%/config/packages/saas_kit')
            ->info('the path to the tenants json configurations files')
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}