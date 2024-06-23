<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit\Inspector;

use AttributeAutoRegisterBundle\Inspector\FileInspector;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

#[CoversClass(FileInspector::class)]
class FileInspectorTest extends TestCase
{
    private FileInspector $fileInspector;

    public function setUp(): void
    {
        $this->fileInspector = new FileInspector();
    }

    public function testGetFullQualifiedNamespace(): void
    {
        $file = new SplFileInfo('App/Entity/TestClass.php', 'tests/Functional/App/Entity', 'TestClass.php');

        static::assertSame('App\Entity\TestClass', $this->fileInspector->getFullQualifiedNamespace($file));
    }

    /**
     * @throws Exception
     */
    public function testGetFullQualifiedNamespaceWithInvalidFile(): void
    {
        $file = $this->createMock(SplFileInfo::class);
        $file->method('getContents')->willReturn('');

        static::assertEmpty($this->fileInspector->getFullQualifiedNamespace($file));
    }
}
