<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Factory;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use LogicException;
use Symfony\Component\DependencyInjection\Definition;

class DefinitionFactory
{
    public function createFromAttribute(Autowired $attribute): Definition
    {
        $definition = (new Definition($attribute->id))
            ->setTags($attribute->aliases)
            ->setAutoconfigured(true)
            ->setPublic(true)
            ->setAutowired(true);

        if ($attribute->factory !== null) {
            if ($attribute->factoryMethod === null) {
                throw new LogicException('Factory method must be set when factory is set');
            }
            $definition->setFactory([$attribute->factory, $attribute->factoryMethod]);
        }

        return $definition;
    }

    public function createFromNamespace(string $class): Definition
    {
        return (new Definition($class))
            ->setAutoconfigured(true)
            ->setPublic(true)
            ->setAutowired(true);
    }
}
