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

    /** @return \DOMDocument|null */
    public function xmlDocument(): ?\DOMDocument;

    /** @return \DateTime */
    public function lastFeedItemDate(): \DateTime;
}
