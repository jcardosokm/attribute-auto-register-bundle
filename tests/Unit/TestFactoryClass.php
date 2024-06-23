<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Tests\Unit;

use App\Factory\FactoryClassFactory;
use AttributeAutoRegisterBundle\Attribute\Autowired;

#[Autowired (id: 'factory_class_a', factory: FactoryClassFactory::class, factoryMethod: 'createA')]
#[Autowired (id: 'factory_class_b', factory: FactoryClassFactory::class, factoryMethod: 'createB')]
class TestFactoryClass
{
    public function __construct(private string $testConfig)
    {
    }

    public function getTestConfig(): string
    {
        return $this->testConfig;
    }
}
