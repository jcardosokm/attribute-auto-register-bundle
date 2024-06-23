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

    public function testGetFullQualifiedClassName(): void
    {
        $file = new SplFileInfo('tests/Functional/App/Entity/TestClass.php', 'tests/Functional/App/Entity', 'TestClass.php');

        $fqn = $this->fileInspector->getFullQualifiedClassName($file);
        static::assertSame('AttributeAutoRegisterBundle\Tests\Functional\App\Entity\TestClass', $fqn);
    }

    /**
     * @throws Exception
     */
    public function testGetFullQualifiedClassNameWithInvalidFile(): void
    {
        $file = $this->createMock(SplFileInfo::class);
        $file->method('getContents')->willReturn('');

        static::assertEmpty($this->fileInspector->getFullQualifiedClassName($file));
    }
}
