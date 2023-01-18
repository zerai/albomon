<?php

declare(strict_types=1);

namespace Albomon\Core\Application\Service\RssReader;

/**
 * Interface RssReaderResultInterface.
 */
interface RssReaderResultInterface
{
    public function httpStatus(): bool;

    public function httpError(): string;

    public function feedUrl(): string;


    public function xmlDocument(): ?\DOMDocument;


    public function lastFeedItemDate(): \DateTime;
}
