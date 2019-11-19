<?php

declare(strict_types=1);

namespace Albomon\Core\Application\Service\RssReader;

/**
 * Interface RssReaderInterface.
 */
interface RssReaderInterface
{
    public function execute(string $targetUrl): RssReaderResultInterface;
}
