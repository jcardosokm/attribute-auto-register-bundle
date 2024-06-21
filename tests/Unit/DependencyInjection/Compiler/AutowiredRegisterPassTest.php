<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit\DependencyInjection\Compiler;

use AttributeAutoRegisterBundle\DependencyInjection\Compiler\AutowiredRegisterPass;
use AttributeAutoRegisterBundle\Factory\DefinitionFactory;
use AttributeAutoRegisterBundle\Inspector\FileInspector;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Throwable;

#[CoversClass(AutowiredRegisterPass::class)]
class AutowiredRegisterPassTest extends TestCase
{
    private AutowiredRegisterPass $compilerPass;

    public function setUp(): void
    {
        parent::setUp();
        $this->compilerPass = new AutowiredRegisterPass(
            $this->createMock(FileInspector::class),
            $this->createMock(DefinitionFactory::class),
            $this->createMock(Finder::class)
        );
    }

    /**
     * @throws Throwable
     */
    public function testProcess(): void
    {
        $container = $this->createMock(ContainerBuilder::class);
        $this->compilerPass->process($container);

        static::assertEmpty($container->getDefinitions());
    }
}
