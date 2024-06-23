<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional\App\Entity;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Tests\Functional\App\TaggedServices\TaggedServiceInterface;
use Exception;
use IteratorAggregate;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

#[Autowired]
class TestClass
{
    public function __construct(#[AutowireIterator('tagged_service')] private IteratorAggregate $taggedServices)
    {
    }

    /**
     * @return TaggedServiceInterface[]
     * @throws Exception
     */
    public function getTaggedServices(): array
    {
        return iterator_to_array($this->taggedServices->getIterator());
    }
}
