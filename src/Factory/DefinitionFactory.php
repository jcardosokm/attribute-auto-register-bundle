<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Factory;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use Symfony\Component\DependencyInjection\Definition;

class DefinitionFactory
{
    /**
     * @param class-string $fqn
     */
    public function create(string $fqn, ?Autowired $attribute = null): Definition
    {
        $definition = (new Definition($fqn))
            ->setAutoconfigured(true)
            ->setPublic(true)
            ->setAutowired(true);

        if ($attribute === null) {
            return $definition;
        }

        foreach ($attribute->aliases as $tag) {
            $definition->addTag($tag);
        }

        if ($attribute->factory !== null) {
            $definition->setFactory([$attribute->factory, $attribute->factoryMethod]);
        }

        return $definition;
    }
}
