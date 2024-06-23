<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Validator;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use LogicException;

class AttributeValidator
{
    public function validate(Autowired $attribute, string $fileContent): void
    {
        if ($attribute->factory !== null) {
            if ($attribute->factoryMethod === null) {
                throw new LogicException('Factory method must be set when factory is set');
            }
            if (str_contains($fileContent, 'function ' . $attribute->factoryMethod) === false) {
                throw new LogicException('Factory method ' . $attribute->factoryMethod . ' not found in ' . $attribute->factory);
            }
            if (str_contains($fileContent, 'static function ' . $attribute->factory) === false) {
                throw new LogicException('Method ' . $attribute->factoryMethod . ' must be declared static');
            }
            if (str_contains($fileContent, 'public static function ' . $attribute->factory) === false) {
                throw new LogicException('Method ' . $attribute->factoryMethod . ' must be declared public');
            }
        }
    }
}
