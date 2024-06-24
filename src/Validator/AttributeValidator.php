<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Validator;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use LogicException;
use ReflectionClass;
use ReflectionException;

class AttributeValidator
{
    /**
     * @throws ReflectionException
     */
    public function validate(Autowired $attribute): bool
    {
        if ($attribute->factory !== null) {
            $factory = new ReflectionClass($attribute->factory);

            if ($attribute->factoryMethod === null) {
                throw new LogicException('Factory method must be set when factory is set');
            }

            if ($factory->hasMethod($attribute->factoryMethod) === false) {
                throw new LogicException('Factory method ' . $attribute->factoryMethod . ' not found in ' . $factory->getShortName());
            }

            $method = $factory->getMethod($attribute->factoryMethod);
            if ($method->isStatic() === false) {
                throw new LogicException('Method ' . $attribute->factoryMethod . ' must be declared static');
            }

            if ($method->isPublic() === false) {
                throw new LogicException('Method ' . $attribute->factoryMethod . ' must be declared public');
            }
        }

        return true;
    }
}
