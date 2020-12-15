<?php declare(strict_types=1);


use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    // paths to refactor; solid alternative to CLI arguments
    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);

    // Rector relies on autoload setup of your project; Composer autoload is included by default; to add more:
    $parameters->set(Option::AUTOLOAD_PATHS, [
        // autoload specific file
        //__DIR__ . '/vendor/squizlabs/php_codesniffer/autoload.php',
        // or full directory
        //__DIR__ . '/vendor/project-without-composer',
    ]);
    //var_dump(PHP_VERSION_ID);
    // is your PHP version different from the one your refactor to? [default: your PHP version], uses PHP_VERSION_ID format
    //$parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_72);
    $parameters->set(Option::PHP_VERSION_FEATURES, 70200);

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        //SetList::DEAD_CODE,
        //SetList::PHP_71,
        //SetList::PHP_72,
        SetList::SYMFONY_40,
    ]);

    // auto import fully qualified class names? [default: false]
    $parameters->set(Option::AUTO_IMPORT_NAMES, true);

    // skip root namespace classes, like \DateTime or \Exception [default: true]
    $parameters->set(Option::IMPORT_SHORT_CLASSES, false);

    // skip classes used in PHP DocBlocks, like in /** @var \Some\Class */ [default: true]
    $parameters->set(Option::IMPORT_DOC_BLOCKS, false);

    // Run Rector only on changed files
    $parameters->set(Option::ENABLE_CACHE, true);
};