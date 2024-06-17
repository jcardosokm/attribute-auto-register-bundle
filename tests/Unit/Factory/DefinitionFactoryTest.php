<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit\Factory;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Factory\DefinitionFactory;
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

    public function testCreateDefinitionFromAttribute(): void
    {
        $attribute = new Autowired(
            'UT\Autowired',
            'UT\Factory',
            'UT\FactoryMethod',
            ['UT\AutowiredAlias']
        );

        $definition = $this->factory->createFromAttribute($attribute);

        static::assertSame($attribute->id, $definition->getClass());
        static::assertSame([$attribute->factory, $attribute->factoryMethod], $definition->getFactory());
        static::assertSame($attribute->aliases, $definition->getTags());
        static::assertTrue($definition->isPublic());
        static::assertTrue($definition->isAutowired());
    }

    public function testCreateDefinition(): void
    {
        $namespace  = 'UT\Namespace';
        $definition = $this->factory->createFromNamespace($namespace);

        static::assertSame($namespace, $definition->getClass());
        static::assertTrue($definition->isPublic());
        static::assertTrue($definition->isAutowired());
    }
}
