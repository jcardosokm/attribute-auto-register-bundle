<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional\App\Entity;

use AttributeAutoRegisterBundle\Attribute\Autowired;
use AttributeAutoRegisterBundle\Tests\Functional\App\TaggedServices\TaggedServiceA;
use AttributeAutoRegisterBundle\Tests\Functional\App\TaggedServices\TaggedServiceB;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Traversable;

#[Autowired]
class TestClass
{
    /** @var array<TaggedServiceA|TaggedServiceB> */
    private array $taggedServices;

    public function __construct(#[AutowireIterator('tagged_service')] Traversable $taggedServices)
    {
        $this->taggedServices = iterator_to_array($taggedServices);
    }

    public function getTaggedServices(): iterable
    {
        return $this->taggedServices;
    }
}
