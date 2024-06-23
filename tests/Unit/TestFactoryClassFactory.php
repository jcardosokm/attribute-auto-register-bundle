<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit;

use App\Entity\FactoryClass;

class TestFactoryClassFactory
{
    public const CONFIG_A = 'configA';
    public const CONFIG_B = 'configB';

    public static function createA(): FactoryClass
    {
        return new FactoryClass( self::CONFIG_A);
    }

    public static function createB(): FactoryClass
    {
        return new FactoryClass(self::CONFIG_B);
    }
}
