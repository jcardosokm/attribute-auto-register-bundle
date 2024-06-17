<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * @internal
 */
final class AttributeAutoRegisterExtension extends Extension
{
    /**
     * @SuppressWarnings("PMD.UnusedFormalParameter")
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
    }
}
