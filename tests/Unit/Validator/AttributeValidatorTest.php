<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit\Validator;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Tests\Unit\TestFactoryClassFactory;
use AttributeAutoRegisterBundle\Validator\AttributeValidator;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeValidator::class)]
class AttributeValidatorTest extends TestCase
{
    private AttributeValidator $validator;

    public function setUp(): void
    {
        $this->validator = new AttributeValidator();
    }

    public function testValidate(): void
    {
        $attribute   = new Autowired(factory: TestFactoryClassFactory::class, factoryMethod: 'create');
        $fileContent = file_get_contents('tests/Unit/TestFactoryClassFactory.php');

        static::assertTrue($this->validator->validate($attribute, $fileContent));
    }

    public function testValidateWithoutFactoryMethod(): void
    {
        $attribute   = new Autowired(factory: TestFactoryClassFactory::class);
        $fileContent = file_get_contents('tests/Unit/TestFactoryClassFactory.php');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Factory method must be set when factory is set');
        $this->validator->validate($attribute, $fileContent);
    }

    public function testValidateFactoryMethodNotFound(): void
    {
        $attribute   = new Autowired(factory: TestFactoryClassFactory::class, factoryMethod: 'create');
        $fileContent = '';

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Factory method create not found in TestFactoryClassFactory');
        $this->validator->validate($attribute, $fileContent);
    }

    public function testValidateFactoryNotStaticMethod(): void
    {
        $attribute   = new Autowired(factory: TestFactoryClassFactory::class, factoryMethod: 'createNotStatic');
        $fileContent = 'private function createNotStatic()';

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Method createNotStatic must be declared static');
        $this->validator->validate($attribute, $fileContent);
    }

    public function testValidateFactoryMethodNotStatic(): void
    {
        $attribute   = new Autowired(factory: TestFactoryClassFactory::class, factoryMethod: 'create');
        $fileContent = 'private static function create()';

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Method create must be declared public');
        $this->validator->validate($attribute, $fileContent);
    }
}
