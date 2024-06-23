<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional;

use AttributeAutoRegisterBundle\Tests\Functional\App\Entity\FactoryClass;
use AttributeAutoRegisterBundle\Tests\Functional\App\Entity\TestClass;
use AttributeAutoRegisterBundle\Tests\Functional\App\TaggedServices\TaggedServiceInterface;
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
        static::assertInstanceOf(TestClass::class, $testClass);

        $taggedServices = $testClass->getTaggedServices();
        static::assertCount(2, $taggedServices);

        foreach ($taggedServices as $taggedService) {
            static::assertInstanceOf(TaggedServiceInterface::class, $taggedService);
        }
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
