<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\FactoryClass;

class FactoryClassFactory
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
