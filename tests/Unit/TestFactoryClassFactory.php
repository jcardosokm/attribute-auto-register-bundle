<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit;

use AttributeAutoRegisterBundle\Tests\Functional\App\Entity\FactoryClass;

class TestFactoryClassFactory
{
    public const CONFIG = 'config';

    public static function create(): FactoryClass
    {
        return new FactoryClass( self::CONFIG);
    }
}
