<?php

declare(strict_types=1);

namespace App\Entity;

use App\TaggedServices\TaggedServiceA;
use App\TaggedServices\TaggedServiceB;
use AttributeAutoRegisterBundle\Attribute\Autowired;
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
