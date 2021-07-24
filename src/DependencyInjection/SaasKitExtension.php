<?php
namespace ZedMagdy\Bundle\SaasKitBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SaasKitExtension extends Extension implements PrependExtensionInterface
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('saas_kit.identifier', $config['identifier']);
        $container->setParameter('saas_kit.tenants_files_path', $config['tenants_files_path']);
        $container->setParameter('saas_kit.factory.class', $config['factory']['class']);
        $container->setParameter('saas_kit.factory.method', $config['factory']['method']);
    }

    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('twig', [
            'form_themes' => ['bootstrap_5_layout.html.twig']
        ]);
        $container->prependExtensionConfig('framework', [
            'messenger' => [
                'routing' => [
                    'ZedMagdy\Bundle\SaasKitBundle\Messages\CreateTenant' => 'async'
                ]
            ]
        ]);
    }
}