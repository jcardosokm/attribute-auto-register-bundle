<?php

declare(strict_types=1);

namespace DR\AttributeAutoRegisterBundle\Tests\Functional;

use AttributeAutoRegisterBundle\AttributeAutoRegisterBundle;
use Exception;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

final class TestKernel extends Kernel
{
    /**
     * @return iterable<int|string, BundleInterface>
     */
    public function registerBundles(): iterable
    {
        return [new FrameworkBundle(), new AttributeAutoRegisterBundle()];
    }

    /**
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir() . "/config/config.yml");
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }
}
