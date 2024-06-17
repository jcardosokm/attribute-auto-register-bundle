<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Autowired
{
    /**
     * @param array<string> $aliases
     */
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $factory = null,
        public readonly ?string $factoryMethod = null,
        public readonly array $aliases = []
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAliases(): array
    {
        return $this->aliases;
    }

    public function getFactory(): string
    {
        return $this->factory;
    }

    public function getFactoryMethod(): string
    {
        return $this->factory;
    }
}
