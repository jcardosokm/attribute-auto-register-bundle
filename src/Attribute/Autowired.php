<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Autowired
{
    /**
     * @codeCoverageIgnore
     * @param array<string> $aliases
     */
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $factory = null,
        public readonly ?string $factoryMethod = null,
        public readonly array $aliases = [],
        public readonly \stdClass $stdClass = null
    ) {
    }
}
