<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Attribute;

use Attribute;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Autowired
{
    /**
     * @param array<string> $aliases
     */
    #[CodeCoverageIgnore]
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $factory = null,
        public readonly ?string $factoryMethod = null,
        public readonly array $aliases = []
    ) {
    }
}
