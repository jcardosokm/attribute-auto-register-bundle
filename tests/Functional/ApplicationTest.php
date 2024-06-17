<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional;

use App\TestClasse;
use Exception;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
class ApplicationTest extends AbstractKernelTestCase
{
    /**
     * @throws Exception
     */
    public function testShouldLoad(): void
    {
        /** @var object $container */
        $container = self::getContainer();
        $class = $container->get(TestClasse::class);

        static::assertInstanceOf(TestClasse::class, $class);
    }
}
