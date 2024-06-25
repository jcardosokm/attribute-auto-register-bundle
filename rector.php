<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Utils\Rector\Rector\AutowiredAttributeGenerateRule;

return RectorConfig::configure()
    ->withImportNames()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/utils',
    ])// ->withPhpSets()
    ->withRules([
        AutowiredAttributeGenerateRule::class,
    ]);
