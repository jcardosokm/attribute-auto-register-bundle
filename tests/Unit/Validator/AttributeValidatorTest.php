<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit\Validator;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Tests\Unit\TestFactoryClassFactory;
use AttributeAutoRegisterBundle\Validator\AttributeValidator;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

#[CoversClass(AttributeValidator::class)]
class AttributeValidatorTest extends TestCase
{
    private AttributeValidator $validator;

    public function setUp(): void
    {
        $this->validator = new AttributeValidator();
    }

    /**
     * @throws ReflectionException
     */
    public function testValidateWithNullFactory(): void
    {
        $attribute = new Autowired();

        static::assertTrue($this->validator->validate($attribute));
    }

    /**
     * @throws ReflectionException
     */
    public function testValidateWithFactoryAndNullFactoryMethod(): void
    {
        $attribute = new Autowired(factory: TestFactoryClassFactory::class);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Factory method must be set when factory is set');

        $this->validator->validate($attribute);
    }

    /**
     * @throws ReflectionException
     */
    public function testValidateWithFactoryAndNonExistentFactoryMethod(): void
    {
        $attribute = new Autowired(factory: TestFactoryClassFactory::class, factoryMethod: 'nonExistentMethod');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Factory method nonExistentMethod not found in TestFactoryClassFactory');

        $this->validator->validate($attribute);
    }

    /**
     * @throws ReflectionException
     */
    public function testValidateWithFactoryAndNonStaticFactoryMethod(): void
    {
        $attribute = new Autowired(factory: TestFactoryClassFactory::class, factoryMethod: 'nonStaticMethod');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Method nonStaticMethod must be declared static');

        $this->validator->validate($attribute);
    }

    /**
     * @throws ReflectionException
     */
    public function testValidateWithFactoryAndNonPublicFactoryMethod(): void
    {
        $attribute = new Autowired(factory: TestFactoryClassFactory::class, factoryMethod: 'nonPublicMethod');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Method nonPublicMethod must be declared public');

        $this->validator->validate($attribute);
    }

    /**
     * @throws ReflectionException
     */
    public function testValidateWithFactoryAndValidFactoryMethod(): void
    {
        $attribute = new Autowired(factory: TestFactoryClassFactory::class, factoryMethod: 'validMethod');

        static::assertTrue($this->validator->validate($attribute));
    }
}
