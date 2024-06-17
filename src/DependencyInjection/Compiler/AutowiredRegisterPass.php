<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\DependencyInjection\Compiler;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Factory\DefinitionFactory;
use AttributeAutoRegisterBundle\Inspector\FileInspector;
use ReflectionClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Throwable;

class AutowiredRegisterPass implements CompilerPassInterface
{
    /** @var array<string, Definition> */
    private array $definitions = [];

    public function __construct(
        private readonly FileInspector $fileInspector = new FileInspector(),
        private readonly DefinitionFactory $definitionFactory = new DefinitionFactory(),
        private readonly Finder $finder = new Finder()
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @throws Throwable
     */
    public function process(ContainerBuilder $container): void
    {
        $filePaths = [dirname(__DIR__, 2) . '\temp'];

        $this->finder->name('*.php')->in($filePaths);

        /** @var SplFileInfo $file */
        foreach ($this->finder as $file) {
            $content = $file->getContents();

            if (str_contains($content, '#[Autowired') === false) {
                continue;
            }

            $namespace = $this->fileInspector->getNamespace($file);

            if (str_contains($content, '#[Autowired]')) {
                $this->definitions[$namespace] = $this->definitionFactory->createFromNamespace($namespace);
                continue;
            }

            if (class_exists($namespace) === false || interface_exists($namespace)) {
                continue;
            }

            $reflectionClass = new ReflectionClass($namespace);
            if ($reflectionClass->isAbstract()) {
                continue;
            }

            $attributes = $reflectionClass->getAttributes(Autowired::class);

            /** @var ReflectionClass<Autowired> $attribute */
            foreach ($attributes as $attribute) {
                $attr = $attribute->newInstance();
                $this->definitions[$attr->id ?? $namespace] = $this->definitionFactory->createFromAttribute($attr);
            }
        }

        $container->addDefinitions($this->definitions);
    }
}
