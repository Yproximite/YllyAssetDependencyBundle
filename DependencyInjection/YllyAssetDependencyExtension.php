<?php

namespace Ylly\AssetDependencyBundle\DependencyInjection ;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class YllyAssetDependencyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('assets.xml');

        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        if (isset($config['javascript_alias_map'])) {
            foreach ($config['javascript_alias_map'] as $alias => $path) {
                $container->getDefinition('ylly_asset_dependency.assets_manager')
                    ->addMethodCall('addPathAlias', array('javascript', $alias, $path));
            }
        }

        if (isset($config['stylesheet_alias_map'])) {
            foreach ($config['stylesheet_alias_map'] as $alias => $path) {
                $container->getDefinition('ylly_asset_dependency.assets_manager')
                    ->addMethodCall('addPathAlias', array('stylesheet', $alias, $path));
            }
        }
    }

    public function getXsdValidationBasePath()
    {
        return null;
    }

    public function getNamespace()
    {
        return null;
    }

    public function getAlias()
    {
        return 'ylly_asset_dependency';
    }
}


