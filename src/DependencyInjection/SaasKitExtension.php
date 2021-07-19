<?php
namespace ZedMagdy\Bundle\SaasKitBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SaasKitExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/../config'));
        $loader->load('services.xml');
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);
        $definition = $container->getDefinition("saas_kit.request.subscriber");
        $definition->replaceArgument(0, $config['identifier']);
        $definition->replaceArgument(1, $config['tenants_files_path']);
    }
}