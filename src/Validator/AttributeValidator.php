<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Validator;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use LogicException;
use Symfony\Component\DependencyInjection\Definition;

class AttributeValidator
{
    /**
     * @param class-string $fqn
     */
    public function validate(string $fqn, string $content = '', ?Autowired $attribute = null): Definition
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

            $definition->setFactory([$attribute->factory, $attribute->factoryMethod]);
        }

        return $definition;
    }
}
