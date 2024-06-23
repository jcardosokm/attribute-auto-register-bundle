<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional\App\Entity;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Tests\Functional\App\TaggedServices\TaggedServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

#[Autowired]
class TestClass
{
    /**
     * @param iterable $taggedServices
     */
    public function __construct(#[AutowireIterator('tagged_service')] private iterable $taggedServices)
    {
    }

    /**
     * @return array<TaggedServiceInterface>
     */
    public function getTaggedServices(): iterable
    {
        return $this->taggedServices;
    }
}
