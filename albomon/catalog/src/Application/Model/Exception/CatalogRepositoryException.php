<?php declare(strict_types=1);

namespace Albomon\Catalog\Application\Model\Exception;

class CatalogRepositoryException extends \RuntimeException implements ExceptionInterface
{
    public static function catalogFileNotFound(string $catalogFilename): self
    {
        return new CatalogRepositoryException("Expected catalog file '$catalogFilename' not found.");
    }
}
