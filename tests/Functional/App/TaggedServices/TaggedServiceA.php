<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Functional\App\TaggedServices;

use AttributeAutoRegisterBundle\Attribute\Autowired;

#[Autowired(aliases: ['tagged_service'])]
class TaggedServiceA implements TaggedServiceInterface
{
}
