<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle;

use AttributeAutoRegisterBundle\DependencyInjection\AttributeAutoRegisterExtension;
use AttributeAutoRegisterBundle\DependencyInjection\Compiler\AutowiredRegisterPass;
use AttributeAutoRegisterBundle\Factory\DefinitionFactory;
use AttributeAutoRegisterBundle\Inspector\FileInspector;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @codeCoverageIgnore - This is a bundle class, tested by the functional test
 */
final class AttributeAutoRegisterBundle extends Bundle
{
    public function __construct()
    {
        // This is a bundle class, tested by the functional test
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(
            new AutowiredRegisterPass(
                new FileInspector(),
                new DefinitionFactory(),
                new Finder()
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function getContainerExtension(): ExtensionInterface
    {
        return new AttributeAutoRegisterExtension();
    }
}
