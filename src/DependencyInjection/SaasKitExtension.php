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
        $container->setParameter('saas_kit.identifier', $config['identifier']);
        $container->setParameter('saas_kit.tenants_files_path', $config['tenants_files_path']);
    }
}