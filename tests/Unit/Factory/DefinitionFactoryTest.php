<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit\Factory;

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

    public function testCreateDefinition(): void
    {
        $namespace  = 'UT\Namespace';
        $definition = $this->factory->createFromNamespace($namespace);

        static::assertSame($namespace, $definition->getClass());
    }
}
