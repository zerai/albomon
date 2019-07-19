<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Exception;

class CatalogFileNotFoundException extends \Exception
{
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function withFilename(string $filename, int $code = 0, \Exception $previous = null): self
    {
        return new self(sprintf('Catalog file not found. %s', $filename), $code, $previous);
    }
}
