<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\DependencyInjection\Compiler;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Factory\DefinitionFactory;
use AttributeAutoRegisterBundle\Inspector\FileInspector;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Throwable;

class AutowiredRegisterPass implements CompilerPassInterface
{
    public function __construct(
        private readonly FileInspector $fileInspector = new FileInspector(),
        private readonly DefinitionFactory $definitionFactory = new DefinitionFactory(),
        private readonly Finder $finder = new Finder()
    ) {
    }

    /**
     * @throws Throwable
     */
    public function process(ContainerBuilder $container): void
    {
        $filePaths = [dirname(__DIR__, 3) . '/tests/Functional/App'];

        $this->finder->name('*.php')->in($filePaths);

        /** @var SplFileInfo $file */
        foreach ($this->finder as $file) {
            $content = $file->getContents();

            if (str_contains($content, '#[Autowired') === false) {
                continue;
            }

            $namespace = $this->fileInspector->getNamespace($file);

            if ($this->shouldSkipNamespace($namespace)) {
                continue;
            }

            if (str_contains($content, '#[Autowired]')) {
                $container->setDefinition($namespace, $this->definitionFactory->createFromNamespace($namespace));
                continue;
            }

            $this->processAttributes($namespace, $container);
        }
    }

    private function shouldSkipNamespace(string $namespace): bool
    {
        return $namespace === '' || class_exists($namespace) === false || interface_exists($namespace);
    }

    /**
     * @throws ReflectionException
     */
    private function processAttributes(string $namespace, ContainerBuilder $container): void
    {
        /** @var ReflectionClass<Autowired> $attribute */
        $reflectionClass = new ReflectionClass($namespace);
        if ($reflectionClass->isAbstract()) {
            return;
        }

        $attributes = $reflectionClass->getAttributes(Autowired::class);

        foreach ($attributes as $attribute) {
            $attr = $attribute->newInstance();
            $container->setDefinition($attr->id ?? $namespace, $this->definitionFactory->createFromAttribute($attr, $namespace));
        }
    }
}
