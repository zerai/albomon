<?php declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->cacheDirectory(__DIR__ . '/var/cache_tools/ecs');
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/albomon/core/src',
        __DIR__ . '/albomon/core/tests',
        __DIR__ . '/albomon/catalog/src',
        __DIR__ . '/albomon/catalog/tests',
        __DIR__ . '/ecs.php',
        __DIR__ . '/rector.php',
    ]);

    $ecsConfig->skip([
        __DIR__ . '/src/Kernel.php',
        __DIR__ . '/tests/bootstrap.php',
        BlankLineAfterOpeningTagFixer::class,
    ]);

    /**
     * Full Sets before Standalone Rules
     * It is highly recommended to imports sets (A) first, then add standalone rules (B).
     * The reason for this is that some settings are configured in the full sets too,
     * and will therefore overwrite your standalone rules, if not configured first.
     */
    $ecsConfig->sets([
        SetList::ARRAY,
        SetList::DOCBLOCK,
        SetList::NAMESPACES,
        //SetList::PHPUNIT,
        SetList::PSR_12,
        SetList::SPACES,
    ]);

    $ecsConfig->rules([
        DeclareStrictTypesFixer::class,
        BlankLineAfterNamespaceFixer::class,
        NoUnusedImportsFixer::class,
        OrderedImportsFixer::class,
        NativeFunctionInvocationFixer::class,
        FullyQualifiedStrictTypesFixer::class,
        StrictComparisonFixer::class,

    ]);

    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);
};
