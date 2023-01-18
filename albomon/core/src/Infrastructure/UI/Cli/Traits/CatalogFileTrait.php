<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Traits;

use Albomon\Core\Infrastructure\UI\Cli\Exception\CatalogFileNotFoundException;

trait CatalogFileTrait
{
    /**
     * @throws CatalogFileNotFoundException
     */
    protected function getCatalog(string $catalogDir, string $catalogFilename): array
    {
        $catalogFile = $catalogDir . DIRECTORY_SEPARATOR . $catalogFilename;

        if (! file_exists($catalogFile)) {
            throw CatalogFileNotFoundException::withFilename($catalogFile);
        }

        $strJsonFileContents = file_get_contents($catalogFile);

        $customCatalog = json_decode((string) $strJsonFileContents, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }

        return $customCatalog;
    }
}
