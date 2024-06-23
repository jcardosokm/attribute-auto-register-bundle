<?php

declare(strict_types=1);

namespace App\TaggedServices;

use AttributeAutoRegisterBundle\Attribute\Autowired;

#[Autowired(aliases: ['tagged_service'])]
class TaggedServiceA
{
}
