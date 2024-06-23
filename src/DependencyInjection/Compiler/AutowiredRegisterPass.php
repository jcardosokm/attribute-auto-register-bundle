<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\DependencyInjection\Compiler;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Factory\DefinitionFactory;
use AttributeAutoRegisterBundle\Inspector\FileInspector;
use AttributeAutoRegisterBundle\Validator\AttributeValidator;
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
        private readonly AttributeValidator $attributeValidator,
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
            $fileContent = $file->getContents();

            if (str_contains($fileContent, '#[Autowired') === false) {
                continue;
            }

            $fqcn = $this->fileInspector->getFullQualifiedClassName($file);

            if (class_exists($fqcn) === false || interface_exists($fqcn)) {
                continue;
            }

            if (str_contains($fileContent, '#[Autowired]')) {
                $container->setDefinition($fqcn, $this->definitionFactory->create($fqcn));
                continue;
            }

            $this->processAttributes($fqcn, $fileContent, $container);
        }
    }

    /**
     * @param class-string $fqcn
     * @throws ReflectionException
     */
    private function processAttributes(string $fqcn, string $content, ContainerBuilder $container): void
    {
        $reflectionClass = new ReflectionClass($fqcn);
        if ($reflectionClass->isAbstract()) {
            return;
        }

        $attributes = $reflectionClass->getAttributes(Autowired::class);

        /** @var ReflectionClass<Autowired> $attribute */
        foreach ($attributes as $attribute) {
            $attr = $attribute->newInstance();

            $this->attributeValidator->validate($attr, $content);

            $container->setDefinition($attr->id ?? $fqcn, $this->definitionFactory->create($fqcn, $attr));
        }
    }
}
