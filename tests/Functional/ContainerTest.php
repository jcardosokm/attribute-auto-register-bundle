<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional;

use AttributeAutoRegisterBundle\Tests\Functional\App\TestClasse;
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
    public function testLoad(): void
    {
        $class = $this->container->get(TestClasse::class);

        static::assertInstanceOf(TestClasse::class, $class);
    }
}
