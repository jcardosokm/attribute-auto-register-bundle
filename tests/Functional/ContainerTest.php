<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional;

use App\Entity\FactoryClass;
use App\Entity\TestClass;
use App\TaggedServices\TaggedServiceA;
use App\TaggedServices\TaggedServiceB;
use Exception;
use PHPUnit\Framework\Attributes\CoversNothing;
use Symfony\Component\DependencyInjection\Container;

#[CoversNothing]
class ContainerTest extends AbstractKernelTestCase
{
    private Container $container;

    public function setUp(): void
    {
        parent::setUp();
        $this->container = self::getContainer();
    }

    /**
     * @throws Exception
     */
    public function testNoParameter(): void
    {
        $class = $this->container->get(TestClass::class);

        static::assertInstanceOf(TestClass::class, $class);
    }

    /**
     * @throws Exception
     */
    public function testAttributeAliases(): void
    {
        $testClass = $this->container->get(TestClass::class);
        static::assertNotNull($testClass);

        $taggedServices = $testClass->getTaggedServices();
        static::assertCount(2, $taggedServices);

        static::assertInstanceOf(TaggedServiceA::class, $taggedServices[0]);
        static::assertInstanceOf(TaggedServiceB::class, $taggedServices[1]);
    }

    /**
     * @throws Exception
     */
    public function testAttributeFactory(): void
    {
        $factoryClassA = $this->container->get('factory_class_a');
        static::assertInstanceOf(FactoryClass::class, $factoryClassA);
        static::assertSame('configA', $factoryClassA->getTestConfig());

        $factoryClassB = $this->container->get('factory_class_b');
        static::assertInstanceOf(FactoryClass::class, $factoryClassB);
        static::assertSame('configB', $factoryClassB->getTestConfig());
    }
}
