<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit\Factory;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Factory\DefinitionFactory;
use AttributeAutoRegisterBundle\Tests\Unit\TestFactoryClass;
use AttributeAutoRegisterBundle\Tests\Unit\TestFactoryClassFactory;
use DR\Utils\Assert;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefinitionFactory::class)]
class DefinitionFactoryTest extends TestCase
{
    private DefinitionFactory $factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->factory = new DefinitionFactory();
    }

    public function testCreateWithAttribute(): void
    {
        $fqn       = Assert::classString(TestFactoryClass::class);
        $attribute = new Autowired('id1', TestFactoryClassFactory::class, 'create', ['UT\AutowiredAlias']);

        $definition = $this->factory->create($fqn, '', $attribute);

        static::assertSame($fqn, $definition->getClass());
        static::assertSame([$attribute->factory, $attribute->factoryMethod], $definition->getFactory());
        static::assertSame(['UT\AutowiredAlias' => [0 => []]], $definition->getTags());
        static::assertTrue($definition->isPublic());
        static::assertTrue($definition->isAutowired());
    }

    public function testCreateWithAttributeWithoutFactoryMethod(): void
    {
        $fqn       = Assert::classString('AttributeAutoRegisterBundle\Tests\Unit\TestFactoryClass');
        $attribute = new Autowired('id3', 'MyFactory', aliases: ['autowiredAlias']);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Factory method must be set when factory is set');

        $definition = $this->factory->create($fqn, '', $attribute);

        static::assertSame($fqn, $definition->getClass());
        static::assertNull($definition->getFactory());
        static::assertSame($attribute->aliases, $definition->getTags());
        static::assertTrue($definition->isPublic());
        static::assertTrue($definition->isAutowired());
    }

    public function testCreate(): void
    {
        $fqn        = Assert::classString(TestFactoryClass::class);
        $definition = $this->factory->create($fqn);

        static::assertSame($fqn, $definition->getClass());
        static::assertTrue($definition->isPublic());
        static::assertTrue($definition->isAutowired());
    }
}
