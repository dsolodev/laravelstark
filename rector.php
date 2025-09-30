<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Exception\Configuration\InvalidConfigurationException;
use RectorLaravel\Set\LaravelSetProvider;

try {
    return RectorConfig::configure()
        ->withPaths([
            __DIR__.'/app',
        ])
        ->withSetProviders(LaravelSetProvider::class)
        ->withComposerBased(laravel: true);
} catch (InvalidConfigurationException $e) {
    logger()->error($e->getMessage());
}
