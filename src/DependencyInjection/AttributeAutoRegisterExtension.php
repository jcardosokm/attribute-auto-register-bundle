<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * @phpstan-type Options array{
 *      filePaths: array{int, string}
 *  }
 * @codeCoverageIgnore - This is a configuration class, tested by the functional test
 * @internal
 */
final class AttributeAutoRegisterExtension extends Extension
{
    /**
     * @phpstan-param Options $configs
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter('attribute_auto_register.file_paths', array_values($config['filePaths']));
    }
}
