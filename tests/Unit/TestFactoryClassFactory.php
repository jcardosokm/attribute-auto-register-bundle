<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit;

class TestFactoryClassFactory
{
    public static function validMethod(): void
    {
    }

    public function nonStaticMethod(): void
    {
    }

    protected static function nonPublicMethod(): void
    {
    }
}
