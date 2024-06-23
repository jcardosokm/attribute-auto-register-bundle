<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional\App\Entity;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Tests\Functional\App\TaggedServices\TaggedServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Traversable;

#[Autowired]
class TestClass
{
    public function __construct(#[AutowireIterator('tagged_service')] private Traversable $taggedServices)
    {
    }

    /**
     * @return array<TaggedServiceInterface>
     */
    public function getTaggedServices(): iterable
    {
        return iterator_to_array($this->taggedServices);
    }
}
