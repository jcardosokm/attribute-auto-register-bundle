<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\DependencyInjection\Compiler;

use AttributeAutoRegisterBundle\DependencyInjection\Compiler\AutowiredRegisterPass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Throwable;

#[CoversClass(AutowiredRegisterPass::class)]
class AutowiredRegisterPassTest extends TestCase
{
    private AutowiredRegisterPass $compilerPass;

    public function setUp(): void
    {
        parent::setUp();
        $this->compilerPass = new AutowiredRegisterPass();
    }

    /**
     * @throws Throwable
     */
    public function testProcess(): void
    {
        $container = $this->createMock(ContainerBuilder::class);
        $this->compilerPass->process($container);

        static::assertC($container->getDefinitions());
    }
}
