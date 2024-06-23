<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Validator;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use LogicException;

class AttributeValidator
{
    public function validate(Autowired $attribute, string $fileContent): bool
    {
        if ($attribute->factory !== null) {
            if ($attribute->factoryMethod === null) {
                throw new LogicException('Factory method must be set when factory is set');
            }
            if (str_contains($fileContent, 'function ' . $attribute->factoryMethod . '(') === false) {
                $className = $this->getClassName($attribute->factory);
                throw new LogicException('Factory method ' . $attribute->factoryMethod . ' not found in ' . $className);
            }
            if (str_contains($fileContent, 'static function ' . $attribute->factoryMethod . '(') === false) {
                throw new LogicException('Method ' . $attribute->factoryMethod . ' must be declared static');
            }
            if (str_contains($fileContent, 'public static function ' . $attribute->factoryMethod . '(') === false) {
                throw new LogicException('Method ' . $attribute->factoryMethod . ' must be declared public');
            }
        }

        return true;
    }

    private function getClassName(string $fqcn): string
    {
        $array = explode('\\', $fqcn);

        return end($array);
    }
}
