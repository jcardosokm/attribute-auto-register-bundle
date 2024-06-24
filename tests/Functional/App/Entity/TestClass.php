<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional\App\Entity;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Tests\Functional\App\TaggedServices\TaggedServiceInterface;
use Exception;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Traversable;

#[Autowired]
class TestClass
{
    /**
     * @param Traversable<TaggedServiceInterface> $taggedServices
     */
    public function __construct(#[TaggedIterator('tagged_service')] private readonly Traversable $taggedServices)
    {
    }

    /**
     * @return TaggedServiceInterface[]
     * @throws Exception
     */
    public function getTaggedServices(): array
    {
        return iterator_to_array($this->taggedServices);
    }
}
