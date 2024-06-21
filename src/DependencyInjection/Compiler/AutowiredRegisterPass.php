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

/**
 * @codeCoverageIgnore
 */
class AutowiredRegisterPass implements CompilerPassInterface
{
    public function __construct(
        private readonly FileInspector $fileInspector,
        private readonly DefinitionFactory $definitionFactory,
        private readonly Finder $finder
    ) {
    }

    /**
     * @throws Throwable
     */
    public function process(ContainerBuilder $container): void
    {
        $filePaths = $container->getParameter('attribute_auto_register.file_paths');
        if (is_array($filePaths) === false) {
            return;
        }

        $this->finder->name('*.php')->in($filePaths);

        /** @var SplFileInfo $file */
        foreach ($this->finder as $file) {
            $content = $file->getContents();

            if (str_contains($content, '#[Autowired') === false) {
                continue;
            }

            $fqn = $this->fileInspector->getFullQualifiedNamespace($file);

            if (class_exists($fqn) === false || interface_exists($fqn)) {
                continue;
            }

            if (str_contains($content, '#[Autowired]')) {
                $container->setDefinition($fqn, $this->definitionFactory->create($fqn));
                continue;
            }

            $this->processAttributes($fqn, $container);
        }
    }

    /**
     * @param class-string $namespace
     * @throws ReflectionException
     */
    private function processAttributes(string $namespace, ContainerBuilder $container): void
    {
        $reflectionClass = new ReflectionClass($namespace);
        if ($reflectionClass->isAbstract()) {
            return;
        }

        $attributes = $reflectionClass->getAttributes(Autowired::class);

        /** @var ReflectionClass<Autowired> $attribute */
        foreach ($attributes as $attribute) {
            $attr = $attribute->newInstance();
            $container->setDefinition($attr->id ?? $namespace, $this->definitionFactory->create($namespace, $attr));
        }
    }
}
