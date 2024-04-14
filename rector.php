<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Symfony\Set\SymfonySetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPhpSets(php81: true)
    ->withSymfonyContainerXml(__DIR__ . '/var/cache/dev/App_KernelDevDebugContainer.xml')
    ->withPaths([
        __DIR__ . '/albomon/core/src',
        __DIR__ . '/albomon/core/tests',
        __DIR__ . '/albomon/catalog/src',
        __DIR__ . '/albomon/catalog/tests',
        __DIR__ . '/src',
        __DIR__ . '/tests',

    ])
    ->withPreparedSets(
        deadCode: false,
        codeQuality: false,
        codingStyle: false
    )
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withRules([
        //AddVoidReturnTypeWhereNoReturnRector::class,
    ])
    ->withSets([
        SymfonySetList::SYMFONY_62,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
    ]);
