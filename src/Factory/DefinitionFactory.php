<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Factory;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use LogicException;
use Symfony\Component\DependencyInjection\Definition;

class DefinitionFactory
{
    /**
     * @param class-string $fqn
     */
    public function create(string $fqn, string $content = '', ?Autowired $attribute = null): Definition
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
            if ($attribute->factoryMethod === null) {
                throw new LogicException('Factory method must be set when factory is set');
            }
            if (method_exists($attribute->factory, $attribute->factoryMethod) === false) {
                throw new LogicException('Factory method does not exist');
            }
            if (strpos($attribute->factoryMethod, '__') === 0) {
                throw new LogicException('Factory method must not be private');
            }

            $definition->setFactory([$attribute->factory, $attribute->factoryMethod]);
        }

        return $definition;
    }
}
