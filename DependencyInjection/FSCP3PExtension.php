<?php

namespace FSC\P3PBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * FSCP3PExtension
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class FSCP3PExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('fsc.p3p.decorator.value', $config['value']);
        $container->setParameter('fsc.p3p.decorator.pattern', $config['pattern']);
    }
}
